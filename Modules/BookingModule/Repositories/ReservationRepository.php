<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Repositories;

use Illuminate\Http\Request;
use Modules\BookingModule\Entities\BookingPaymentTransaction;
use Modules\BookingModule\Entities\Reservation;
use MongoDB\BSON\ObjectId;

class ReservationRepository
{
    private $model;

    public function __construct(Reservation $reservation)
    {
        $this->model = $reservation;
    }

    public function create($data)
    {
        return $this->model->create($data);
    }
}
