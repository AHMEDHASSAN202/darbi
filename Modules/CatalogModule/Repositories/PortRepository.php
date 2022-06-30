<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Illuminate\Http\Request;
use Modules\CatalogModule\Entities\Port;
use Modules\CommonModule\Traits\CrudRepositoryTrait;
use MongoDB\BSON\ObjectId;

class PortRepository
{
    use CrudRepositoryTrait;

    public function __construct(Port $model)
    {
        $this->model = $model;
    }

    public function listOfPorts(Request $request)
    {
        $query = $this->model->search($request)
                             ->filters($request)
                             ->with(['country' => function ($q) { $q->withTrashed(); }, 'city' => function ($q) { $q->withTrashed(); }])
                             ->active()
                             ->latest();

        if ($request->has('paginated')) {
            return $query->paginate($request->get('limit', 20));
        }

        return $query->get();
    }

    public function listOfPortsForDashboard(Request $request, $wheres = [])
    {
        return $this->model->adminSearch($request)->adminFilters($request)->with(['country' => function ($q) { $q->withTrashed(); }, 'city' => function ($q) { $q->withTrashed(); }])->latest()->where($wheres)->paginate($request->get('limit', 20));
    }

    public function findAllPortsByCity($cityId)
    {
        return $this->model->active()->where('city_id', new ObjectId($cityId))->get();
    }

    public function findOne($portId)
    {
        return $this->model->where('_id', new ObjectId($portId))->with(['country' => function ($q) { $q->withTrashed(); }, 'city' => function ($q) { $q->withTrashed(); }])->firstOrFail();
    }
}
