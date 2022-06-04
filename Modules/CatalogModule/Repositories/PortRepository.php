<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Illuminate\Http\Request;
use Modules\CatalogModule\Entities\Port;

class PortRepository
{
    public function __construct(Port $model)
    {
        $this->model = $model;
    }

    public function listOfPorts(Request $request)
    {
        $query = $this->model->search($request)
                             ->active()
                             ->latest();

        if ($request->has('paginated')) {
            return $query->paginate($request->get('limit', 20));
        }

        return $query->get();
    }
}
