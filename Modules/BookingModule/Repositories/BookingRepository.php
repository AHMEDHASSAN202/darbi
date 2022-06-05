<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Repositories;

use Modules\BookingModule\Entities\Booking;

class BookingRepository
{
    private $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function findAllByUser($userId, $limit = 20)
    {
        //->where('user_id', $userId)
        return $this->booking->with('entity')->paginate($limit);
    }

    public function findByUser($userId, $bookingId)
    {
        //->where('user_id', $userId)
        return $this->booking->where('id', $bookingId)->first();
    }

    public function create($data)
    {
        return $this->booking->create($data);
    }
}
