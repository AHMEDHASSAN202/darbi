<?php

namespace Modules\CatalogModule\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Http\Requests\Admin\CreateCarRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateCarRequest;
use Modules\CatalogModule\Services\Admin\CarService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class CarController extends Controller
{
    use ApiResponseTrait;

    private $carService;


    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    public function index(Request $request)
    {
        $cars = $this->carService->findAll($request);

        return $this->apiResponse(compact('cars'));
    }

    public function show($id)
    {
        $car = $this->carService->find($id);

        return $this->apiResponse(compact('car'));
    }

    public function destroy($id)
    {
        $result = $this->carService->deleteByAdmin($id);

        return $this->apiResponse($result['data'], $result['statusCode'], $result['message']);
    }
}
