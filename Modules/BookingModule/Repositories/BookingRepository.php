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
        return $this->booking->where('user_id', $userId)->with('entity')->paginate($limit);
    }

    public function findByUser($userId, $bookingId)
    {
        return $this->booking->where('user_id', $userId)->where('id', $bookingId)->with('entity')->first();
    }

}
