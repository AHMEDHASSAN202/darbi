<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Illuminate\Support\Facades\Log;
use Modules\CatalogModule\Entities\Entity;
use MongoDB\BSON\ObjectId;

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

    public function changeState($entityId, $state)
    {
        try {
            return $this->model->where('_id', new ObjectId($entityId))->update(['state' => $state]);
        }catch (\Exception $exception) {
            Log::error('change state error: ' . $exception->getMessage());
            return false;
        }
    }
}
