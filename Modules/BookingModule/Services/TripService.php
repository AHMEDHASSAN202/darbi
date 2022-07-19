<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Services;

use Illuminate\Support\Facades\DB;
use Modules\BookingModule\Classes\BookingChangeLog;
use Modules\BookingModule\Enums\BookingStatus;
use Modules\BookingModule\Events\BookingStatusChangedEvent;
use Modules\BookingModule\Repositories\BookingRepository;

class TripService
{
    use BookingHelperService;

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

            $this->updateEntityState($data['status'], $booking);

            $session->commitTransaction();

            $booking->refresh();

            event(new BookingStatusChangedEvent($booking));

            return successResponse();

        }catch (\Exception $exception) {
            $session->abortTransaction();
            helperLog(__CLASS__, __FUNCTION__, $exception->getMessage());
            return serverErrorResponse();
        }
    }

    public function endTrip($bookingId)
    {
        $meId = auth('api')->id();
        $me = auth('api')->user();

        $booking = $this->bookingRepository->findByUser($meId, $bookingId);

        abort_if(is_null($booking), 404);

        $this->bookingRepository->update($bookingId, [
            'status'        => BookingStatus::DROPPED,
            'end_trip_at'   => new \MongoDB\BSON\UTCDateTime(now()->timestamp),
            'status_change_log' => (new BookingChangeLog($booking, BookingStatus::PICKED_UP, $me))->logs()
        ]);

        $booking->refresh();

        event(new BookingStatusChangedEvent($booking));

        return successResponse();
    }
}
