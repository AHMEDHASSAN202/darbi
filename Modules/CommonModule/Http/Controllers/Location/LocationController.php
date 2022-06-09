<?php

namespace Modules\CommonModule\Http\Controllers\Location;

use Illuminate\Routing\Controller;
use Modules\CommonModule\Http\Requests\ValidateLatAndLngRequest;
use Modules\CommonModule\Services\LocationService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class LocationController extends Controller
{
    use ApiResponseTrait;

    private $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }


    public function find(ValidateLatAndLngRequest $latAndLngRequest)
    {
        $location = $this->locationService->handleLocation($latAndLngRequest->lat, $latAndLngRequest->lng);

        return $this->apiResponse([
            'location'     => $location
        ]);
    }
}
