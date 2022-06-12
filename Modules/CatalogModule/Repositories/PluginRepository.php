<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Illuminate\Http\Request;
use Modules\CatalogModule\Entities\Brand;
use Modules\CatalogModule\Entities\Plugin;
use Modules\CommonModule\Traits\CrudRepositoryTrait;
use MongoDB\BSON\ObjectId;

class PluginRepository
{
    use CrudRepositoryTrait;

    private $model;

    public function __construct(Plugin $model)
    {
        $this->model = $model;
    }

    public function findAllPlugin($entityId)
    {
        return $this->model->active()->whereHas('entities', function ($query) use ($entityId) { $query->where('_id', new ObjectId($entityId)); })->get();
    }
}
