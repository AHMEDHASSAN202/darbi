<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Repositories;

use Illuminate\Http\Request;
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

    public function findAllByUser($userId, $limit = 20)
    {
        return $this->booking->latest()->where('user_id', new ObjectId($userId))->paginate($limit);
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
        return $this->booking->latest()->adminSearch($request)->adminFilter($request)->where('vendor_id', $vendorId)->paginate($request->get('limit', 20));
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
}
