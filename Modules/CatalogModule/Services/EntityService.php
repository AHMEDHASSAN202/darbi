<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services;

use Illuminate\Http\Request;
use Modules\CatalogModule\Repositories\CarRepository;
use Modules\CatalogModule\Repositories\EntityRepository;
use Modules\CatalogModule\Transformers\CarDetailsResource;
use Modules\CatalogModule\Transformers\CarResource;
use Modules\CatalogModule\Transformers\EntityResource;
use Modules\CommonModule\Transformers\PaginateResource;

class EntityService
{
    private $entityRepository;

    public function __construct(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    public function find($entityId)
    {
        $entity = $this->entityRepository->findById($entityId);

        abort_if(is_null($entity), 404);

        return new EntityResource($entity);
    }
}
