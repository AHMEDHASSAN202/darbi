<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Illuminate\Http\Request;
use Modules\CatalogModule\Entities\Model;
use Modules\CatalogModule\Entities\Port;
use Modules\CommonModule\Traits\CrudRepositoryTrait;
use MongoDB\BSON\ObjectId;

class ModelRepository
{
    use CrudRepositoryTrait;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function listOfModels(Request $request)
    {
        return $this->model->search($request)->filter($request)->active()->latest()->paginated();
    }

    public function listOfModelsForDashboard(Request $request, $wheres = [])
    {
        return $this->model->adminSearch($request)->adminFilters($request)->latest()->with(['brand' => function ($q) { $q->withTrashed(); }])->where($wheres)->paginated();
    }

    public function findOne($modelId)
    {
        return $this->model->with(['brand' => function ($q) { $q->withTrashed(); }])->where('_id', new ObjectId($modelId))->firstOrFail();
    }
}
