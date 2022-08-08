<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services\Admin;

use Modules\CatalogModule\Http\Requests\Admin\CreateEntityRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateEntityRequest;
use Modules\CatalogModule\Repositories\YachtRepository;
use Modules\CommonModule\Traits\ImageHelperTrait;
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


    public function create(CreateEntityRequest $createEntityRequest)
    {
        $data = [
            'port_id'       => new ObjectId($createEntityRequest->port_id),
        ];

        $yacht = $this->createEntity($createEntityRequest, $data);

        return createdResponse(['id' => $yacht->_id]);
    }


    public function update($id, UpdateEntityRequest $updateEntityRequest)
    {
        $data = [
            'port_id'       => new ObjectId($updateEntityRequest->port_id)
        ];

        $yacht = $this->updateEntity($id, $updateEntityRequest, $data);

        return updatedResponse(['id' => $yacht->_id]);
    }
}
