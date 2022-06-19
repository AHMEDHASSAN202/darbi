<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Services\Admin;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\BookingModule\Enums\BookingStatus;
use Modules\BookingModule\Events\BookingStatusChangedEvent;
use Modules\BookingModule\Repositories\BookingRepository;
use Modules\BookingModule\Transformers\Admin\BookingResource;
use Modules\BookingModule\Transformers\Admin\FindBookingResource;
use Modules\CommonModule\Transformers\PaginateResource;
use MongoDB\BSON\ObjectId;

class BookingService
{
    private $bookingRepository;


    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }


    public function acceptByVendor($bookingId)
    {
        $session = DB::connection('mongodb')->getMongoClient()->startSession();
        $session->startTransaction();

        try {
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

            DB::collection('bookings')->where('_id', new ObjectId($bookingId))->update(['status' => BookingStatus::ACCEPT], ['session' => $session]);

            $booking->refresh();

            event(new BookingStatusChangedEvent($booking));

            return [
                'data'       => [
                    'booking_id'    => $bookingId
                ],
                'message'    => '',
                'statusCode' => 200
            ];

            $session->commitTransaction();

        }catch (\Exception $exception) {
            Log::error($exception->getMessage());
            $session->abortTransaction();
            return [
                'data'       => [],
                'message'    => null,
                'statusCode' => 500
            ];
        }
    }


    public function cancelByVendor($bookingId)
    {
        $session = DB::connection('mongodb')->getMongoClient()->startSession();
        $session->startTransaction();

        try {
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

            $status = ($booking->status == BookingStatus::ACCEPT) ? BookingStatus::CANCELLED_AFTER_ACCEPT : BookingStatus::REJECTED;
            DB::collection('bookings')->where('_id', new ObjectId($bookingId))->update(['status' => $status], ['session' => $session]);

            $booking->refresh();

            event(new BookingStatusChangedEvent($booking));

            $session->commitTransaction();

            return [
                'data'       => [
                    'booking_id'    => $bookingId,
                ],
                'message'    => '',
                'statusCode' => 200
            ];

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            $session->abortTransaction();
            return [
                'data'       => [],
                'message'    => null,
                'statusCode' => 500
            ];
        }
    }


    public function getBookingsByVendor(Request $request)
    {
        $vendorId = new ObjectId(getVendorId());

        $bookings = $this->bookingRepository->bookingsByVendor($vendorId, $request);

        return new PaginateResource(BookingResource::collection($bookings));
    }


    public function findBookingByVendor($bookingId)
    {
        $vendorId = new ObjectId(getVendorId());

        $booking = $this->bookingRepository->findByVendor($vendorId, new ObjectId($bookingId));

        return new FindBookingResource($booking);
    }


    public function vendorSales()
    {
        $vendorId = new ObjectId(getVendorId());

        return $this->bookingRepository->vendorSales($vendorId);
    }


    public function vendorOrders()
    {
        $vendorId = new ObjectId(getVendorId());

        return $this->bookingRepository->vendorOrders($vendorId);
    }
}
