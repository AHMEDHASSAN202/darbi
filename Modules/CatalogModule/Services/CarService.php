<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CatalogModule\Repositories\CarRepository;
use Modules\CatalogModule\Transformers\FindCarResource;
use Modules\CatalogModule\Transformers\CarResource;
use Modules\CommonModule\Traits\ImageHelperTrait;
use Modules\CommonModule\Transformers\PaginateResource;

class CarService
{
    use ImageHelperTrait, EntityHelperService;

    private $repository;

    public function __construct(CarRepository $carRepository)
    {
        $this->repository = $carRepository;
    }


    public function findAll(Request $request)
    {
        $cars = $this->repository->listOfCars($request);

        if ($cars instanceof LengthAwarePaginator) {
            return new PaginateResource(CarResource::collection($cars));
        }

        return CarResource::collection($cars);
    }


    public function find($carId)
    {
        $car = $this->repository->findCarWithDetailsById($carId);

        abort_if(is_null($car), 404);

        return new FindCarResource($car);
    }
}
