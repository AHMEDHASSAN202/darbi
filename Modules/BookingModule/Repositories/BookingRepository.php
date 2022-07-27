<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\BookingModule\Entities\Booking;
use Modules\BookingModule\Enums\BookingStatus;
use MongoDB\BSON\ObjectId;

class BookingRepository
{
    private $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function findAllByUser($userId, Request $request)
    {
        return $this->booking->latest()->userFilter($request)->where('user_id', new ObjectId($userId))->paginated();
    }

    public function findByUser($userId, $bookingId)
    {
        return $this->booking->where('_id', new ObjectId($bookingId))->where('user_id', new ObjectId($userId))->firstOrFail();
    }

    public function create($data)
    {
        return $this->booking->create($data);
    }

    public function bookingsByVendor(ObjectId $vendorId, Request $request)
    {
        return $this->booking->latest()->adminSearch($request)->adminFilter($request)->where('vendor_id', $vendorId)->where('status', '!=', BookingStatus::INIT)->paginated();
    }

    public function findAll(Request $request)
    {
        return $this->booking->latest()->adminSearch($request)->adminFilter($request)->where('status', '!=', BookingStatus::INIT)->paginated();
    }

    public function findByAdmin(ObjectId $bookingId)
    {
        return $this->booking->where('_id', $bookingId)->firstOrFail();
    }

    public function findByVendor(ObjectId $vendorId, ObjectId $bookingId)
    {
        return $this->booking->where('vendor_id', $vendorId)->where('_id', $bookingId)->firstOrFail();
    }

    public function vendorSales(ObjectId $vendorId)
    {
        return $this->booking->where('vendor_id', $vendorId)->where('status', BookingStatus::COMPLETED)->sum('price_summary.total_price');
    }

    public function vendorOrders(ObjectId $vendorId)
    {
        return $this->booking->where('vendor_id', $vendorId)->where('status', BookingStatus::COMPLETED)->count();
    }

    public function updateBookingCollection($bookingId, $data, $session)
    {
        return DB::collection('bookings')->where('_id', new ObjectId($bookingId))->update($data, ['session' => $session]);
    }

    public function update($bookingId, $data)
    {
        return $this->booking->where('_id', new ObjectId($bookingId))->update($data);
    }

    public function getTimeoutBookings()
    {
        $timeIntervalUserAccept = intval(getOption('time_interval_user_accept_min', Booking::TIME_INTERVAL_USER_ACCEPT_MIN));
        $timeIntervalVendorAccept = intval(getOption('time_interval_vendor_accept_min', Booking::TIME_INTERVAL_VENDOR_ACCEPT_MIN));

        $timeoutUser = now()->subMinutes($timeIntervalUserAccept);
        $timeoutVendor = now()->subMinutes($timeIntervalVendorAccept);

        return $this->booking->where(function ($query) use ($timeoutVendor) {

            $query->where('status', BookingStatus::PENDING)->where('pending_at', '<', $timeoutVendor);

        })->orWhere(function ($query) use ($timeoutUser) {

            $query->where('status', BookingStatus::ACCEPT)->where('accepted_at', '<', $timeoutUser);

        })->get();
    }

    public function getReminderBookings()
    {
        $timeReminderBeforePickedUp = intval(getOption('time_reminder_before_picked_up', Booking::TIME_REMINDER_BEFORE_PICKED_UP));
        $timeReminderBeforeDropped = intval(getOption('time_reminder_before_dropped', Booking::TIME_REMINDER_BEFORE_DROPPED));

        $timeReminderBeforePickedUpFromNow = now()->addMinutes($timeReminderBeforePickedUp);
        $timeReminderBeforeDroppedFromNow = now()->addMinutes($timeReminderBeforeDropped);

        return $this->booking->where(function ($query) use ($timeReminderBeforePickedUpFromNow) {

            $query->where('status', BookingStatus::PAID)->whereBetween('start_booking_at', [new \DateTime($timeReminderBeforePickedUpFromNow->format('Y-m-d H:i:00')), new \DateTime($timeReminderBeforePickedUpFromNow->format('Y-m-d H:i:59'))]);

        })->orWhere(function ($query) use ($timeReminderBeforeDroppedFromNow) {

            $query->where('status', BookingStatus::PICKED_UP)->whereBetween('end_booking_at', [new \DateTime($timeReminderBeforeDroppedFromNow->format('Y-m-d H:i:00')), new \DateTime($timeReminderBeforeDroppedFromNow->format('Y-m-d H:i:59'))]);

        })->get();
    }
}
