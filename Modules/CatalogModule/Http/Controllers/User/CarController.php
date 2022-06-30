<?php

namespace Modules\CatalogModule\Http\Controllers\User;

use Illuminate\Routing\Controller;
use Modules\CatalogModule\Http\Requests\User\ListOfEntitiesRequest;
use Modules\CatalogModule\Services\CarService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class CarController extends Controller
{
    use ApiResponseTrait;

    private $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    public function index(ListOfEntitiesRequest $entitiesRequest)
    {
        return $this->apiResponse([
            'cars'    => $this->carService->findAll($entitiesRequest)
        ]);
    }

    public function show($carId)
    {
        return $this->apiResponse([
            'car'       => $this->carService->find($carId)
        ]);
    }
}
