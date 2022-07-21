<?php

namespace Modules\BookingModule\Http\Controllers\Internal;

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

    public function timeout()
    {
        $result = $this->bookingService->updateBookingsTimeout();

        return $this->apiResponse(...$result);
    }
}
