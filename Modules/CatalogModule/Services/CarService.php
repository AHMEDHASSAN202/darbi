<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services;

use Illuminate\Http\Request;
use Modules\CatalogModule\Http\Requests\Admin\CreateEntityRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateEntityRequest;
use Modules\CatalogModule\Repositories\CarRepository;
use Modules\CatalogModule\Repositories\ExtraRepository;
use Modules\CatalogModule\Transformers\CarDetailsResource;
use Modules\CatalogModule\Transformers\Admin\EntityResource;
use Modules\CatalogModule\Transformers\CarResource;
use Modules\CommonModule\Traits\ImageHelperTrait;
use Modules\CommonModule\Transformers\PaginateResource;
use MongoDB\BSON\ObjectId;

class CarService
{
    use ImageHelperTrait, EntityHelperService;

    private $repository;
    private $uploadDirectory = 'cars';

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
//        $car->extras = app(ExtraRepository::class)->getPluginsPrice(array_values($car->plugin_ids), $car->vendor_id);
        abort_if(is_null($car), 404);

        return new CarDetailsResource($car);
    }


    public function findAllByVendor(Request $request)
    {
        $cars = $this->repository->findAllByVendor($request, getVendorId());

        return new PaginateResource(EntityResource::collection($cars));
    }


    public function findByVendor($id)
    {
        $car = $this->repository->findByVendor(getVendorId(), $id);

        return new \Modules\CatalogModule\Transformers\Admin\EntityDetailsResource($car);
    }


    public function create(CreateEntityRequest $createCarRequest)
    {
        $car = $this->createEntity($createCarRequest);

        return [
            'id'        => $car->_id
        ];
    }


    public function update($id, UpdateEntityRequest $updateCarRequest)
    {
        $car = $this->updateEntity($id, $updateCarRequest);

        return [
            'id'        => $car->_id
        ];
    }
}
