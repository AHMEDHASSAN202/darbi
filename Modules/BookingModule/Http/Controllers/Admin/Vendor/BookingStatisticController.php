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


    public function __invoke()
    {
        return $this->apiResponse([
            'sales'     => $this->bookingService->vendorSales(),
            'orders'    => $this->bookingService->vendorOrders()
        ]);
    }
}
