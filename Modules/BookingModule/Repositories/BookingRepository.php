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

    public function findAllByUser($userId)
    {
        return $this->booking->latest()->where('user_id', new ObjectId($userId))->paginated();
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
        return DB::collection('bookings')->where('_id', new ObjectId($bookingId))->update($data);
    }
}
