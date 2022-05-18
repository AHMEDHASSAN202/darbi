<?php

namespace Modules\CommonModule\Http\Controllers\Location;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CommonModule\Http\Requests\GetRegionByLatAndLngRequest;
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

    public function findRegionByLatAndLng(GetRegionByLatAndLngRequest $getRegionByLatAndLngRequest)
    {
        $region = $this->regionService->findRegionByLatAndLng($getRegionByLatAndLngRequest);

        if (!$region) {
            return $this->apiResponse([], 404, __('Region Not Found'));
        }

        return $this->apiResponse([
            'region'    => $region
        ]);
    }
}
