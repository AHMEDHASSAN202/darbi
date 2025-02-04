<?php

namespace Modules\BookingModule\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\BookingModule\Entities\Booking;
use Modules\BookingModule\Http\Requests\AddBookDetailsRequest;
use Modules\BookingModule\Http\Requests\CheckoutRequest;
use Modules\BookingModule\Http\Requests\ProceedRequest;
use Modules\BookingModule\Http\Requests\RentRequest;
use Modules\BookingModule\Services\BookingService;
use Modules\BookingModule\Transformers\FindBookingResource;
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
        $result = $this->bookingService->findAllByAuth($request);

        return $this->apiResponse(...$result);
    }


    public function find($bookingId)
    {
        $result = $this->bookingService->findByAuth($bookingId);

        return $this->apiResponse(...$result);
    }


    public function rent(RentRequest $rentRequest)
    {
        $result = $this->bookingService->rent($rentRequest);

        return $this->apiResponse(...$result);
    }


    public function addBookDetails($bookingId, AddBookDetailsRequest $addBookDetailsRequest)
    {
        $result = $this->bookingService->addBookDetails($bookingId, $addBookDetailsRequest);

        return $this->apiResponse(...$result);
    }


    public function proceed($bookingId, ProceedRequest $proceedRequest)
    {
        $result = $this->bookingService->proceed($bookingId, $proceedRequest);

        return $this->apiResponse(...$result);
    }


    public function cancel($bookingId)
    {
        $result = $this->bookingService->cancel($bookingId);

        return $this->apiResponse(...$result);
    }
}
