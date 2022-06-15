<?php

namespace Modules\BookingModule\Http\Controllers\Admin\Vendor;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\BookingModule\Services\BookingService;
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
        $booking = $this->bookingService->acceptByVendor($bookingId);

        return $this->apiResponse(compact('booking'));
    }


    public function cancel($bookingId)
    {
        $booking = $this->bookingService->cancelByVendor($bookingId);

        return $this->apiResponse(compact('booking'));
    }
}
