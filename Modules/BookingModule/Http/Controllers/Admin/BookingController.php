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
        $result = $this->bookingService->findAll($request);

        return $this->apiResponse(...$result);
    }


    public function show($bookingId)
    {
        $result = $this->bookingService->find($bookingId);

        return $this->apiResponse(...$result);
    }


    public function cancel($bookingId)
    {
        $result = $this->bookingService->cancelByAdmin($bookingId);

        return $this->apiResponse(...$result);
    }
}
