<?php

namespace Modules\BookingModule\Http\Controllers\Admin\Vendor;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\BookingModule\Services\Admin\BookingService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class BookingController extends Controller
{
    use ApiResponseTrait;

    private $bookingService;


    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }


    public function index(Request $request)
    {
        $bookings = $this->bookingService->getBookingsByVendor($request);

        return $this->apiResponse(compact('bookings'));
    }


    public function show($bookingId)
    {
        $booking = $this->bookingService->findBookingByVendor($bookingId);

        return $this->apiResponse(compact('booking'));
    }


    public function accept($bookingId)
    {
        $result = $this->bookingService->acceptByVendor($bookingId);

        return $this->apiResponse($result['data'], $result['statusCode'], $result['message']);
    }


    public function cancel($bookingId)
    {
        $result = $this->bookingService->cancelByVendor($bookingId);

        return $this->apiResponse($result['data'], $result['statusCode'], $result['message']);
    }


    public function paid($bookingId)
    {
        $result = $this->bookingService->paidByVendor($bookingId);

        return $this->apiResponse($result['data'], $result['statusCode'], $result['message']);
    }
}
