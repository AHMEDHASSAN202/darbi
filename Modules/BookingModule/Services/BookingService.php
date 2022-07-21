<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Services;

use App\Proxy\Proxy;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\BookingModule\Classes\BookingChangeLog;
use Modules\BookingModule\Classes\Payments\Payment;
use Modules\BookingModule\Classes\Price;
use Modules\BookingModule\Enums\BookingStatus;
use Modules\BookingModule\Events\BookingStatusChangedEvent;
use Modules\BookingModule\Http\Requests\AddBookDetailsRequest;
use Modules\BookingModule\Http\Requests\ProceedRequest;
use Modules\BookingModule\Http\Requests\RentRequest;
use Modules\BookingModule\Proxy\BookingProxy;
use Modules\BookingModule\Repositories\BookingRepository;
use Modules\BookingModule\Transformers\FindBookingResource;
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

        $bookings = $this->bookingRepository->findAllByUser($userId, $request);

        if ($bookings instanceof LengthAwarePaginator) {
            return successResponse(['bookings' => new PaginateResource(BookingResource::collection($bookings))]);
        }

        return successResponse(['bookings' => BookingResource::collection($bookings)]);
    }


    public function findByAuth($bookingId)
    {
        $userId = auth('api')->id();

        $booking = $this->bookingRepository->findByUser($userId, $bookingId);

        return successResponse(['booking' => new FindBookingResource($booking)]);
    }


    public function rent(RentRequest $rentRequest)
    {
        $entity = (new Proxy(new BookingProxy('GET_ENTITY', ['entity_id' => $rentRequest->entity_id])))->result();

        abort_if(is_null($entity), 404);

        $vendor = (new Proxy(new BookingProxy('GET_VENDOR', ['vendor_id' => $entity['vendor_id']])))->result();

        $city = (new Proxy(new BookingProxy('GET_CITY', ['city_id' => $rentRequest->city_id])))->result();

        abort_if((is_null($vendor) || is_null($city)), 404);

        if (!entityIsFree($entity['state'])) {
            return badResponse([], __('booking not allowed'));
        }

        $extras = $this->getExtras($entity, $rentRequest->extras);
        $country = $entity['country'];

        $booking = $this->bookingRepository->create([
            'user_id'       => new ObjectId(auth('api')->id()),
            'user'          => auth('api')->user()->only(['_id', 'phone', 'phone_code', 'name', 'email']),
            'vendor'        => $vendor,
            'vendor_id'     => new ObjectId($entity['vendor_id']),
            'branch_id'     => new ObjectId($entity['branch_id']),
            'branch'        => @$entity['branch'],
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
            'country_id'    => new ObjectId($country['_id']),
            'country'       => $country,
            'currency_code' => $country['currency_code'],
            'city_id'       => $city['id'],
            'city'          => $city,
            'status'        => BookingStatus::INIT,
            'extras'        => $extras,
            'start_booking_at' => $rentRequest->start_at,
            'end_booking_at'   => $rentRequest->end_at
        ]);

        return createdResponse(['booking_id' => $booking->_id]);
    }


    private function getExtras($entity, $extras) : array
    {
        $entityExtras = @$entity['extras'];

        if (!is_array($extras) || empty($extras) || empty($entity) || !is_array($entityExtras)) return [];

        $bookingExtras = [];

        foreach ($entityExtras as $entityExtra) {
            if (in_array($entityExtra['id']['$oid'], $extras)) {
                $bookingExtras[] = $entityExtra;
            }
        }

        return $bookingExtras;
    }


    public function addBookDetails($bookingId, AddBookDetailsRequest $addBookDetailsRequest)
    {
        $meId = auth('api')->id();
        $me = auth('api')->user();

        $booking = $this->bookingRepository->findByUser($meId, $bookingId);

        abort_if((is_null($booking) || $booking->status != BookingStatus::INIT), 404);

        $entity = (new Proxy(new BookingProxy('GET_ENTITY', ['entity_id' => $booking->entity_id])))->result();

        abort_if(is_null($entity), 404);

        if (!entityIsFree($entity['state'])) {
            return badResponse([], __('booking not allowed'));
        }

        $priceSummary = (new Price($entity, $booking->extras, $addBookDetailsRequest->start_at, $addBookDetailsRequest->end_at, $booking->vendor))->getPriceSummary();
        $this->bookingRepository->update($bookingId, [
            'price_summary'                 => $priceSummary,
            'pickup_location_address'       => Arr::only($addBookDetailsRequest->pickup_location, [...locationInfoKeys()]),
            'drop_location_address'         => Arr::only($addBookDetailsRequest->drop_location, [...locationInfoKeys()]),
            'status_change_log'             => (new BookingChangeLog($booking, BookingStatus::PENDING, $me))->logs(),
            'status'                        => BookingStatus::PENDING,
            'start_booking_at'              => convertDateTimeToUTC($me, $addBookDetailsRequest->start_at),
            'end_booking_at'                => convertDateTimeToUTC($me, $addBookDetailsRequest->end_at),
            'pending_at'                    => new \MongoDB\BSON\UTCDateTime(),
            'note'                          => $addBookDetailsRequest->note
        ]);

        $booking->refresh();

        event(new BookingStatusChangedEvent($booking));

        return successResponse();
    }


    public function cancel($bookingId)
    {
        $meId = auth('api')->id();
        $me = auth('api')->user();

        $booking = $this->bookingRepository->findByUser($meId, $bookingId);

        if (!in_array($booking->status, [BookingStatus::INIT, BookingStatus::PENDING, BookingStatus::ACCEPT])) {
            return badResponse([], __('booking not allowed', ['status' => __('cancel')]));
        }

        $cancelledBeforeAccept = BookingStatus::CANCELLED_BEFORE_ACCEPT;
        $this->bookingRepository->update($bookingId, [
            'status_change_log'     => (new BookingChangeLog($booking, $cancelledBeforeAccept, $me))->logs(),
            'status'                => $cancelledBeforeAccept
        ]);

        $booking->refresh();

        event(new BookingStatusChangedEvent($booking));

        return successResponse(['booking_id' => $bookingId]);
    }


    public function proceed($bookingId, ProceedRequest $proceedRequest)
    {
        $meId = auth('api')->id();
        $me = auth('api')->user();

        $booking = $this->bookingRepository->findByUser($meId, $bookingId);

        if ($booking->status != BookingStatus::ACCEPT) {
            return badResponse([], __('booking not allowed', ['status' => __('proceed')]));
        }

        $payment = new Payment($proceedRequest->payment_method, $proceedRequest->all());

        $data['payment_method'] = [
            'type'       => $proceedRequest->payment_method,
            'extra_info' => $payment->storeData()
        ];

        if (!$payment->successTransaction()) {
            $this->bookingRepository->update($bookingId, $data);

            helperLog(__CLASS__, __FUNCTION__, 'Payment Failed');

            return badResponse([], __('Payment Failed'));
        }

        $data['status'] = BookingStatus::PAID;
        $data['status_change_log'] = (new BookingChangeLog($booking, BookingStatus::PAID, $me))->logs();

        $this->bookingRepository->update($bookingId, $data);

        $booking->refresh();

        event(new BookingStatusChangedEvent($booking));

        return successResponse([], __('Payment Successful'));
    }


    public function updateBookingsTimeout()
    {
        $bookings = $this->bookingRepository->getTimeoutBookings();

        foreach ($bookings as $booking) {
            try {

                $this->bookingRepository->update($booking->id, [
                    'status'    => BookingStatus::TIMEOUT,
                    'status_change_log' => (new BookingChangeLog($booking, BookingStatus::TIMEOUT))->logs()
                ]);

                $booking->refresh();

                event(new BookingStatusChangedEvent($booking));

            }catch (\Exception $exception) {
                helperLog(__CLASS__, __FUNCTION__, $exception->getMessage(), $booking->toArray());
            }
        }

        return successResponse();
    }
}
