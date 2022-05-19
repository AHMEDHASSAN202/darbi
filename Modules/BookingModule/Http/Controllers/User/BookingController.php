<?php

namespace Modules\BookingModule\Http\Controllers\User;

use Illuminate\Routing\Controller;
use Modules\BookingModule\Entities\Booking;
use Modules\BookingModule\Transformers\BookingDetailsResource;
use Modules\BookingModule\Transformers\BookingResource;
use Modules\CatalogModule\Entities\Entity;
use Modules\CommonModule\Traits\ApiResponseTrait;
use Modules\CommonModule\Transformers\PaginateResource;

class BookingController extends Controller
{
    use ApiResponseTrait;

    public function findAllByUser()
    {
        return $this->apiResponse([
            'bookings'  => new PaginateResource(BookingResource::collection(Booking::with('entity')->paginate()))
        ]);
    }


    public function find($bookingId)
    {
        return $this->apiResponse([
            'booking'   => new BookingDetailsResource(Booking::with('entity')->find($bookingId))
        ]);
    }
}
