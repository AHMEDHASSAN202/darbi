<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Repositories;

use Modules\BookingModule\Entities\Booking;
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
        //->where('user_id', $userId)
        return $this->booking->paginate($limit);
    }

    public function findByUser($userId, $bookingId)
    {
        //->where('user_id', $userId)
        return $this->booking->where('_id', new ObjectId($bookingId))->firstOrFail();
    }

    public function create($data)
    {
        return $this->booking->create($data);
    }
}
