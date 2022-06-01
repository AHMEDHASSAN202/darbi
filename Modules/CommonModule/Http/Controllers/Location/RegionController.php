<?php

namespace Modules\CommonModule\Http\Controllers\Location;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CommonModule\Http\Requests\GetRegionsByNorthEastAndSouthWestRequest;
use Modules\CommonModule\Http\Requests\ValidateLatAndLngRequest;
use Modules\CommonModule\Services\RegionService;
use Modules\CommonModule\Traits\ApiResponseTrait;
use function view;

class RegionController extends Controller
{
    use ApiResponseTrait;

    private $regionService;

    public function __construct(RegionService $regionService)
    {
        $this->regionService = $regionService;
    }

    public function index(Request $request)
    {
        return $this->apiResponse([
            'regions'   => $this->regionService->regions($request)
        ]);
    }

    public function findRegionsByNorthEastAndSouthWest(GetRegionsByNorthEastAndSouthWestRequest $getRegionsByNorthEastAndSouthWestRequest)
    {
        $regions = $this->regionService->findRegionsByNorthEastAndSouthWest($getRegionsByNorthEastAndSouthWestRequest);

        return $this->apiResponse([
            'regions'    => $regions
        ]);
    }

    public function findRegionByLatAndLng(ValidateLatAndLngRequest $latAndLngRequest)
    {
        $region = $this->regionService->findRegionByLatAndLng($latAndLngRequest->lat, $latAndLngRequest->lng);

        return $this->apiResponse([
            'region'     => $region
        ]);
    }
}
