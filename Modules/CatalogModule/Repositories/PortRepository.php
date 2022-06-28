<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Illuminate\Http\Request;
use Modules\CatalogModule\Entities\Port;
use Modules\CommonModule\Traits\CrudRepositoryTrait;

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
                             ->with(['country', 'city'])
                             ->active()
                             ->latest();

        if ($request->has('paginated')) {
            return $query->paginate($request->get('limit', 20));
        }

        return $query->get();
    }

    public function listOfPortsForDashboard(Request $request, $wheres = [])
    {
        return $this->model->adminSearch($request)->adminFilters($request)->with('country')->latest()->where($wheres)->paginate($request->get('limit', 20));
    }
}
