<?php

namespace Modules\BookingModule\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\BookingModule\Entities\Booking;
use Modules\BookingModule\Http\Requests\AddBookDetailsRequest;
use Modules\BookingModule\Http\Requests\CheckoutRequest;
use Modules\BookingModule\Http\Requests\RentRequest;
use Modules\BookingModule\Services\BookingService;
use Modules\BookingModule\Transformers\BookingDetailsResource;
use Modules\BookingModule\Transformers\BookingResource;
use Modules\CatalogModule\Entities\Entity;
use Modules\CommonModule\Traits\ApiResponseTrait;
use Modules\CommonModule\Transformers\PaginateResource;

class BookingController extends Controller
{
    use ApiResponseTrait;

    private $bookingService;


    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }


    public function findAllByUser(Request $request)
    {
        return $this->apiResponse([
            'bookings'  => $this->bookingService->findAllByAuth($request)
        ]);
    }


    public function find($bookingId)
    {
        return $this->apiResponse([
            'booking'   => new BookingDetailsResource(Booking::with('entity')->find($bookingId))
        ]);
    }


    public function rent(RentRequest $rentRequest)
    {
        $result = $this->bookingService->rent($rentRequest);

        return $this->apiResponse($result['data'], $result['statusCode'], $result['message']);
    }


    public function addBookDetails($bookingId, AddBookDetailsRequest $addBookDetailsRequest)
    {
        $result = $this->bookingService->addBookDetails($bookingId, $addBookDetailsRequest);

        return $this->apiResponse($result['data'], $result['statusCode'], $result['message']);
    }


    public function checkout(CheckoutRequest $checkoutRequest)
    {

    }


    public function cancel($bookingId)
    {
        $result = $this->bookingService->cancel($bookingId);

        return $this->apiResponse($result['data'], $result['statusCode'], $result['message']);
    }
}
