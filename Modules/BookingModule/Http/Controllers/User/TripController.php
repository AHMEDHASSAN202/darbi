<?php

namespace Modules\BookingModule\Http\Controllers\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\BookingModule\Services\TripService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class TripController extends Controller
{
    use ApiResponseTrait;

    private $tripService;

    public function __construct(TripService $tripService)
    {
        $this->tripService = $tripService;
    }

    public function startMyTrip($bookingId)
    {
        $result = $this->tripService->startTrip($bookingId);

        return $this->apiResponse($result['data'], $result['statusCode'], $result['message']);
    }

    public function endMyTrip($bookingId)
    {
        $result = $this->tripService->endTrip($bookingId);

        return $this->apiResponse($result['data'], $result['statusCode'], $result['message']);
    }
}
