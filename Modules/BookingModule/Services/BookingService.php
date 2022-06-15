<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Services;

use App\Proxy\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Modules\BookingModule\Classes\Payments\Payment;
use Modules\BookingModule\Classes\Price;
use Modules\BookingModule\Enums\BookingStatus;
use Modules\BookingModule\Http\Requests\AddBookDetailsRequest;
use Modules\BookingModule\Http\Requests\ProceedRequest;
use Modules\BookingModule\Http\Requests\RentRequest;
use Modules\BookingModule\Proxy\BookingProxy;
use Modules\BookingModule\Repositories\BookingRepository;
use Modules\BookingModule\Transformers\BookingDetailsResource;
use Modules\BookingModule\Transformers\BookingResource;
use Modules\CommonModule\Transformers\PaginateResource;
use MongoDB\BSON\ObjectId;

class BookingService
{
    private $bookingRepository;


    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }


    public function findAllByAuth(Request $request)
    {
        $userId = auth('api')->id();

        $bookings = $this->bookingRepository->findAllByUser($userId, $request->get('limit', 20));

        return new PaginateResource(BookingResource::collection($bookings));
    }


    public function findByAuth($bookingId)
    {
        $userId = auth('api')->id();

        $booking = $this->bookingRepository->findByUser($userId, $bookingId);

        return new BookingDetailsResource($booking);
    }


    public function rent(RentRequest $rentRequest)
    {
        $entity = (new Proxy(new BookingProxy('GET_ENTITY', ['entity_id' => $rentRequest->entity_id])))->result();

        abort_if(is_null($entity), 404);

        if (!entityIsFree($entity['state'])) {
            return [
                'statusCode'    => 400,
                'data'          => [],
                'message'       => __('booking not allowed')
            ];
        }

        $extras = $this->getExtras($entity, $rentRequest->extras);

        $booking = $this->bookingRepository->create([
            'user_id'       => new ObjectId(auth('api')->id()),
            'user'          => auth('api')->user()->only(['_id', 'phone', 'phone_code', 'name', 'email']),
            'vendor_id'     => new ObjectId($entity['vendor_id']),
            'entity_id'     => new ObjectId($entity['id']),
            'entity_type'   => @$entity['entity_type'],
            'entity_details' => [
                'name'      => @$entity['name'] ?? "",
                'price'     => @$entity['price'],
                'price_unit'=> @$entity['price_unit'],
                'images'    => @$entity['images'],
                'model_id'  => isset($entity['model_id']) ? new ObjectId($entity['model_id']) : null,
                'model_name'=> @$entity['model_name'],
                'brand_id'  => isset($entity['brand_id']) ? new ObjectId($entity['brand_id']) : null,
                'brand_name'=> @$entity['brand_name'],
            ],
            'status'        => BookingStatus::INIT,
            'extras'        => $extras,
            'start_booking_at' => $rentRequest->start_at,
            'end_booking_at'   => $rentRequest->end_at
        ]);

        return [
            'statusCode'    => 201,
            'message'       => '',
            'data'          => [
                'booking_id'    => $booking->_id
            ]
        ];
    }


    private function getExtras($entity, $plugins) : array
    {
        $entityExtras = @$entity['extras'];

        if (!is_array($plugins) || empty($plugins) || empty($entity) || !is_array($entityExtras)) return [];

        $bookingExtras = [];

        foreach ($entityExtras as $entityExtra) {
            if (in_array($entityExtra['id'], $plugins)) {
                $bookingExtras[] = $entityExtra;
            }
        }

        return $bookingExtras;
    }


    public function addBookDetails($bookingId, AddBookDetailsRequest $addBookDetailsRequest)
    {
        $meId = auth('api')->id();

        $booking = $this->bookingRepository->findByUser($meId, $bookingId);

        abort_if((is_null($booking) || $booking->status != BookingStatus::INIT), 404);

        $entity = (new Proxy(new BookingProxy('GET_ENTITY', ['entity_id' => $booking->entity_id])))->result();

        abort_if(is_null($entity), 404);

        if (!entityIsFree($entity['state'])) {
            return [
                'statusCode'    => 400,
                'data'          => [],
                'message'       => __('booking not allowed')
            ];
        }

        $priceSummary = (new Price($entity, $booking->extras, $addBookDetailsRequest->start_at, $addBookDetailsRequest->end_at))->getPriceSummary();
        $booking->price_summary = $priceSummary;
        $booking->pickup_location_address = Arr::only($addBookDetailsRequest->pickup_location, [...locationInfoKeys()]);
        $booking->drop_location_address = Arr::only($addBookDetailsRequest->drop_location, [...locationInfoKeys()]);
        $booking->status = BookingStatus::PENDING;
        $booking->start_booking_at = $addBookDetailsRequest->start_at;
        $booking->end_booking_at = $addBookDetailsRequest->end_at;
        $booking->note = $addBookDetailsRequest->note;
        $booking->save();

        return [
            'data'          => [],
            'message'       => '',
            'statusCode'    => 200
        ];
    }


    public function cancel($bookingId)
    {
        $userId = auth('api')->id();

        $booking = $this->bookingRepository->findByUser($userId, $bookingId);

        abort_if(is_null($booking), 404);

        if (!in_array($booking->status, [BookingStatus::INIT, BookingStatus::PENDING])) {
            return [
                'data'      => [],
                'message'   => __('cancel booking not allowed'),
                'statusCode'=> 400
            ];
        }

        $booking->status = BookingStatus::CANCELLED_BEFORE_ACCEPT;
        $booking->save();

        return [
            'data'       => [
                'booking_id'    => $bookingId
            ],
            'message'    => '',
            'statusCode' => 200
        ];
    }


    public function acceptByVendor($bookingId)
    {
        $vendorId = getVendorId();

        $booking = $this->bookingRepository->findByVendor(new ObjectId($vendorId), new ObjectId($bookingId));

        abort_if(is_null($booking), 404);

        if ($booking->status != BookingStatus::PENDING) {
            return [
                'data'      => [],
                'message'   => __('accept booking not allowed'),
                'statusCode'=> 400
            ];
        }

        $booking->status = BookingStatus::ACCEPT;
        $booking->save();

        return [
            'data'       => [
                'booking_id'    => $bookingId
            ],
            'message'    => '',
            'statusCode' => 200
        ];
    }


    public function cancelByVendor($bookingId)
    {
        $vendorId = getVendorId();

        $booking = $this->bookingRepository->findByVendor(new ObjectId($vendorId), new ObjectId($bookingId));

        abort_if(is_null($booking), 404);

        if (!in_array($booking->status, [BookingStatus::PENDING, BookingStatus::ACCEPT])) {
            return [
                'data'      => [],
                'message'   => __('cancel booking not allowed'),
                'statusCode'=> 400
            ];
        }

        $booking->status = ($booking->status == BookingStatus::ACCEPT) ? BookingStatus::CANCELLED_AFTER_ACCEPT : BookingStatus::REJECTED;
        $booking->save();

        return [
            'data'       => [
                'booking_id'    => $bookingId
            ],
            'message'    => '',
            'statusCode' => 200
        ];
    }


    public function proceed($bookingId, ProceedRequest $proceedRequest)
    {
        $userId = auth('api')->id();

        $booking = $this->bookingRepository->findByUser($userId, $bookingId);

        abort_if((is_null($booking) || $booking->status != BookingStatus::ACCEPT), 404);

        $booking->status = BookingStatus::PAID;
        $booking->save();

        return [
            'statusCode'       => 200,
            'message'          => __('payment successful'),
            'data'             => []
        ];

        if ($booking->status != BookingStatus::ACCEPT) {
            return [
                'data'      => [],
                'message'   => __('proceed booking not allowed'),
                'statusCode'=> 400
            ];
        }

        $payment = new Payment($proceedRequest->payment_method, $proceedRequest->all());

        $booking->payment_method = [
            'type'  => $proceedRequest->payment_method,
            'extra_info' => $payment->storeData()
        ];

        if (!$payment->successTransaction()) {
            $booking->save();
            Log::error('payment failed', $booking->toArray());
            return [
                'statusCode'       => 400,
                'message'          => __('something error'),
                'data'             => []
            ];
        }

        $booking->status = BookingStatus::PAID;
        $booking->save();

        return [
            'statusCode'       => 200,
            'message'          => __('payment successful'),
            'data'             => []
        ];
    }


    public function getBookingsByVendor(Request $request)
    {
        $vendorId = new ObjectId(getVendorId());

        $bookings = $this->bookingRepository->bookingsByVendor($vendorId, $request);

        return new PaginateResource(\Modules\BookingModule\Transformers\Admin\BookingResource::collection($bookings));
    }


    public function findBookingByVendor($bookingId)
    {
        $vendorId = new ObjectId(getVendorId());

        $booking = $this->bookingRepository->findByVendor($vendorId, new ObjectId($bookingId));

        return new \Modules\BookingModule\Transformers\Admin\BookingDetailsResource($booking);
    }
}
