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

        abort_if(is_null($car), 404);

        return new CarDetailsResource($car);
    }


    public function findByVendor($id)
    {
        $vendorId = new ObjectId(getVendorId());
        $id = new ObjectId($id);
        $car = $this->repository->findByVendor($vendorId, $id);

        return new \Modules\CatalogModule\Transformers\Admin\FindEntityResource($car);
    }


    public function create(CreateEntityRequest $createCarRequest)
    {
        $car = $this->createEntity($createCarRequest, [
            'branch_ids'    => generateObjectIdOfArrayValues($createCarRequest->branch_ids)
        ]);

        return [
            'id'        => $car->_id
        ];
    }


    public function update($id, UpdateEntityRequest $updateCarRequest)
    {
        $car = $this->updateEntity($id, $updateCarRequest, [
            'branch_ids'    => generateObjectIdOfArrayValues($updateCarRequest->branch_ids)
        ]);

        return [
            'id'        => $car->_id
        ];
    }
}
