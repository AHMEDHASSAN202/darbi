<?php

namespace Modules\CommonModule\Http\Controllers\Location;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CommonModule\Services\CityService;
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

    public function find($id)
    {
        $result = $this->cityService->find($id);

        return $this->apiResponse(...$result);
    }
}
