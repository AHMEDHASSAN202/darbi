<?php

namespace Modules\BookingModule\Http\Controllers\Admin;

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
        $bookings = $this->bookingService->findAll($request);

        return $this->apiResponse(compact('bookings'));
    }


    public function show($bookingId)
    {
        $booking = $this->bookingService->find($bookingId);

        return $this->apiResponse(compact('booking'));
    }


    public function cancel($bookingId)
    {
        $result = $this->bookingService->cancelByAdmin($bookingId);

        return $this->apiResponse($result['data'], $result['statusCode'], $result['message']);
    }
}
