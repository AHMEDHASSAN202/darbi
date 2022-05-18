<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services;

use Illuminate\Http\Request;
use Modules\CatalogModule\Repositories\CarRepository;
use Modules\CatalogModule\Transformers\CarDetailsResource;
use Modules\CatalogModule\Transformers\CarResource;
use Modules\CommonModule\Transformers\PaginateResource;

class CarService
{
    private $carRepository;

    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }


    public function findAll(Request $request)
    {
        $cars = $this->carRepository->listOfCars($request);

        return new PaginateResource(CarResource::collection($cars));
    }


    public function find($carId)
    {
        $car = $this->carRepository->findCarWithDetailsById($carId);

        abort_if(is_null($car), 404);

        return new CarDetailsResource($car);
    }
}
