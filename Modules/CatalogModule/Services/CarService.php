<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services;

use Illuminate\Http\Request;
use Modules\CatalogModule\Repositories\CarRepository;
use Modules\CatalogModule\Transformers\FindCarResource;
use Modules\CatalogModule\Transformers\CarResource;
use Modules\CommonModule\Traits\ImageHelperTrait;
use Modules\CommonModule\Transformers\PaginateResource;

class CarService
{
    use ImageHelperTrait;

    public function __construct(CarRepository $carRepository)
    {
        $this->repository = $carRepository;
    }


    public function findAll(Request $request)
    {
        $cars = $this->repository->listOfCars($request);

        return new PaginateResource(CarResource::collection($cars));
    }


    public function find($carId)
    {
        $car = $this->repository->findCarWithDetailsById($carId);

        abort_if(is_null($car), 404);

        return new FindCarResource($car);
    }
}
