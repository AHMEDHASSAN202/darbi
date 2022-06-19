<?php

namespace Modules\BookingModule\Http\Controllers\Admin\Vendor;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\BookingModule\Services\Admin\BookingService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class BookingStatisticController extends Controller
{
    use ApiResponseTrait;

    private $bookingService;


    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }


    public function sales()
    {
        $sales = $this->bookingService->vendorSales();

        return $this->apiResponse(compact('sales'));
    }


    public function orders()
    {
        $orders = $this->bookingService->vendorOrders();

        return $this->apiResponse(compact('orders'));
    }
}
