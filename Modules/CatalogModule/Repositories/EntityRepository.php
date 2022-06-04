<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Modules\CatalogModule\Entities\Entity;

class EntityRepository
{
    public function __construct(Entity $model)
    {
        $this->model = $model;
    }

    public function findById($entityId)
    {
        return $this->model->with(['model', 'brand', 'plugins' => function ($query) { $query->active(); }, 'country', 'city'])->findOrFail($entityId);
    }
}
