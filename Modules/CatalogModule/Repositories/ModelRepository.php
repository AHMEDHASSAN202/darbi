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

class ModelRepository
{
    use CrudRepositoryTrait;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function listOfModels(Request $request)
    {
        $query = $this->model->search($request)
                             ->filter($request)
                             ->active()
                             ->latest();

        if ($request->has('paginated')) {
            return $query->paginate($request->get('limit', 20));
        }

        return $query->get();
    }

    public function listOfModelsForDashboard(Request $request, $wheres = [])
    {
        $query = $this->model->adminSearch($request)->adminFilters($request)->latest()->where($wheres);

        if ($request->has('paginated')) {
            return $query->paginate($request->get('limit', 20));
        }

        return $query->get();
    }
}
