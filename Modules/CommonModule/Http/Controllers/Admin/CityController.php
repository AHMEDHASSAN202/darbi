<?php

namespace Modules\CommonModule\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CommonModule\Services\Admin\CityService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class CityController extends Controller
{
    use ApiResponseTrait;

    private $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    public function index(Request $request)
    {
        $result = $this->cityService->findAll($request);

        return $this->apiResponse(...$result);
    }

    public function toggleActive($cityId)
    {
        $result = $this->cityService->toggleActive($cityId);

        return $this->apiResponse(...$result);
    }
}
