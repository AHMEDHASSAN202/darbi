<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Services;

use App\Proxy\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\BookingModule\Classes\Payments\Payment;
use Modules\BookingModule\Classes\Price;
use Modules\BookingModule\Enums\BookingStatus;
use Modules\BookingModule\Http\Requests\AddBookDetailsRequest;
use Modules\BookingModule\Http\Requests\ProceedRequest;
use Modules\BookingModule\Http\Requests\RentRequest;
use Modules\BookingModule\Proxy\BookingProxy;
use Modules\BookingModule\Repositories\BookingRepository;
use Modules\BookingModule\Transformers\BookingResource;
use Modules\CommonModule\Transformers\PaginateResource;

class TripService
{
    private $bookingRepository;

    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function startTrip($bookingId)
    {
        $booking = $this->bookingRepository->findByUser(auth('api')->id(), $bookingId);

        abort_if((is_null($booking) || $booking->status != BookingStatus::PAID), 404);

        if (!$booking->start_booking_at || $booking->start_booking_at->greaterThanOrEqualTo(now())) {
            return [
                'statusCode'    => 400,
                'data'          => [],
                'message'       => 'The booking start date has not started'
            ];
        }

        $booking->start_trip_at = now();
        $booking->status = BookingStatus::PICKED_UP;
        $booking->save();

        return [
            'statusCode'    => 200,
            'data'          => [],
            'message'       => ''
        ];
    }

    public function endTrip($bookingId)
    {
        $booking = $this->bookingRepository->findByUser(auth('api')->id(), $bookingId);

        abort_if(is_null($booking), 404);

        $booking->end_trip_at = now();
        $booking->status = BookingStatus::DROPPED;
        $booking->save();

        return [
            'statusCode'    => 200,
            'data'          => [],
            'message'       => ''
        ];
    }
}
