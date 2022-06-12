<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services;

use Illuminate\Http\Request;
use Modules\CatalogModule\Http\Requests\Admin\CreateEntityRequest;
use Modules\CatalogModule\Http\Requests\Admin\CreateYachtRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateEntityRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateYachtRequest;
use Modules\CatalogModule\Repositories\YachtRepository;
use Modules\CatalogModule\Transformers\Admin\EntityDetailsResource;
use Modules\CatalogModule\Transformers\Admin\EntityResource;
use Modules\CatalogModule\Transformers\YachtDetailsResource;
use Modules\CatalogModule\Transformers\YachtResource;
use Modules\CommonModule\Traits\ImageHelperTrait;
use Modules\CommonModule\Transformers\PaginateResource;
use MongoDB\BSON\ObjectId;

class YachtService
{
    use EntityHelperService, ImageHelperTrait;


    private $repository;
    private $uploadDirectory = 'yachts';

    public function __construct(YachtRepository $yachtRepository)
    {
        $this->repository = $yachtRepository;
    }

    public function findAll(Request $request)
    {
        $yachts = $this->repository->listOfYachts($request);

        return new PaginateResource(YachtResource::collection($yachts));
    }

    public function find($yachtId)
    {
        $yacht = $this->repository->findYachtWithDetailsById($yachtId);

        abort_if(is_null($yacht), 404);

        return new YachtDetailsResource($yacht);
    }


    public function findAllByVendor(Request $request)
    {
        $yachts = $this->repository->findAllByVendor($request, getVendorId());

        return new PaginateResource(EntityResource::collection($yachts));
    }


    public function findByVendor($id)
    {
        $yacht = $this->repository->findByVendor(getVendorId(), $id);

        return new EntityDetailsResource($yacht);
    }


    public function create(CreateEntityRequest $createEntityRequest)
    {
        $data = [
            'port_id'       => new ObjectId($createEntityRequest->port_id),
            'name'          => ['ar' => $createEntityRequest->name['ar'], 'en' => $createEntityRequest->name['en']]
        ];

        $yacht = $this->createEntity($createEntityRequest, $data);

        return [
            'id'        => $yacht->_id
        ];
    }


    public function update($id, UpdateEntityRequest $updateEntityRequest)
    {
        $data = [
            'port_id'       => new ObjectId($updateEntityRequest->port_id),
            'name'          => ['ar' => $updateEntityRequest->name['ar'], 'en' => $updateEntityRequest->name['en']]
        ];

        $yacht = $this->updateEntity($id, $updateEntityRequest, $data);

        return [
            'id'        => $yacht->_id
        ];
    }
}
