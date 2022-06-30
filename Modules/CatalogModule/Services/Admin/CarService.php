<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services\Admin;

use Modules\CatalogModule\Http\Requests\Admin\CreateEntityRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateEntityRequest;
use Modules\CatalogModule\Repositories\CarRepository;
use Modules\CatalogModule\Transformers\Admin\FindEntityResource;
use Modules\CommonModule\Traits\ImageHelperTrait;
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


    public function findByVendor($id)
    {
        $vendorId = new ObjectId(getVendorId());
        $id = new ObjectId($id);
        $car = $this->repository->findByVendor($vendorId, $id);

        return new FindEntityResource($car);
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
