<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services\Admin;

use Modules\CatalogModule\Http\Requests\Admin\CreateEntityRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateEntityRequest;
use Modules\CatalogModule\Repositories\CarRepository;
use Modules\CatalogModule\Repositories\ModelRepository;
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
        $model = app(ModelRepository::class)->find($createCarRequest->model_id);

        $car = $this->createEntity($createCarRequest, [
            'branch_id'    => new ObjectId($createCarRequest->branch_id),
            'model_id'     => new ObjectId($model->_id),
            'brand_id'     => new ObjectId($model->brand_id),
            'color'        => $createCarRequest->color
        ]);

        return createdResponse(['id' => $car->_id]);
    }


    public function update($id, UpdateEntityRequest $updateCarRequest)
    {
        $model = app(ModelRepository::class)->find($updateCarRequest->model_id);

        $car = $this->updateEntity($id, $updateCarRequest, [
            'branch_id'    => new ObjectId($updateCarRequest->branch_id),
            'model_id'     => new ObjectId($model->_id),
            'brand_id'     => new ObjectId($model->brand_id),
            'color'        => $updateCarRequest->color
        ]);

        return updatedResponse(['id' => $car->_id]);
    }
}
