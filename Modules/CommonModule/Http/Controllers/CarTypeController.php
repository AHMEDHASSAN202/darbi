<?php

namespace Modules\CommonModule\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CommonModule\Services\CarTypeService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class CarTypeController extends Controller
{
    use ApiResponseTrait;

    private $carTypeService;

    public function __construct(CarTypeService $carTypeService)
    {
        $this->carTypeService = $carTypeService;
    }

    public function __invoke(Request $request)
    {
        $result = $this->carTypeService->findAll($request);

        return $this->apiResponse(...$result);
    }
}
