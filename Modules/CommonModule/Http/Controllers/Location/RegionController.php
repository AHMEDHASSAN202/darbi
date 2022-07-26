<?php

namespace Modules\CommonModule\Http\Controllers\Location;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CommonModule\Services\RegionService;
use Modules\CommonModule\Traits\ApiResponseTrait;

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
        $result = $this->regionService->regions($request);

        return $this->apiResponse(...$result);
    }
}
