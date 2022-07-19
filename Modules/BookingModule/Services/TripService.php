<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Services;

use App\Proxy\Proxy;
use Illuminate\Http\Request;
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
use Modules\BookingModule\Transformers\BookingResource;
use Modules\CommonModule\Transformers\PaginateResource;
use MongoDB\BSON\ObjectId;

class TripService
{
    private $bookingRepository;

    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function startTrip($bookingId)
    {
        $meId = auth('api')->id();
        $me = auth('api')->user();

        $booking = $this->bookingRepository->findByUser($meId, $bookingId);

        abort_if((is_null($booking)), 404);

        if ($booking->status != BookingStatus::PAID) {
            return badResponse([], __('Please pay first'));
        }

        if (!$booking->start_booking_at || $booking->start_booking_at->greaterThanOrEqualTo(now())) {
            return badResponse([], __('The booking start date has not started'));
        }

        $session = DB::connection('mongodb')->getMongoClient()->startSession();
        $session->startTransaction();

        try {

            $data['status'] = BookingStatus::PICKED_UP;
            $data['start_trip_at'] = new \MongoDB\BSON\UTCDateTime(now()->timestamp);
            $data['status_change_log'] = (new BookingChangeLog($booking, BookingStatus::PICKED_UP, $me))->logs();
            $this->bookingRepository->updateBookingCollection($bookingId, $data, $session);

            $booking->refresh();

            event(new BookingStatusChangedEvent($booking));

            $session->commitTransaction();

            return successResponse();

        }catch (\Exception $exception) {
            helperLog(__CLASS__, __FUNCTION__, $exception->getMessage());
            $session->abortTransaction();
            return serverErrorResponse();
        }
    }

    public function endTrip($bookingId)
    {
        $meId = auth('api')->id();
        $me = auth('api')->user();

        $booking = $this->bookingRepository->findByUser($meId, $bookingId);

        abort_if(is_null($booking), 404);

        $session = DB::connection('mongodb')->getMongoClient()->startSession();
        $session->startTransaction();

        try {

            $data['status'] = BookingStatus::DROPPED;
            $data['end_trip_at'] = new \MongoDB\BSON\UTCDateTime(now()->timestamp);
            $data['status_change_log'] = (new BookingChangeLog($booking, BookingStatus::PICKED_UP, $me))->logs();
            $this->bookingRepository->updateBookingCollection($bookingId, $data, $session);

            $booking->refresh();

            event(new BookingStatusChangedEvent($booking));

            $session->commitTransaction();

            return successResponse();

        }catch (\Exception $exception) {
            helperLog(__CLASS__, __FUNCTION__, $exception->getMessage());
            $session->abortTransaction();
            return serverErrorResponse();
        }
    }
}
