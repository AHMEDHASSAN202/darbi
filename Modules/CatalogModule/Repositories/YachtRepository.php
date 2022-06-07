<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Illuminate\Http\Request;
use Modules\CatalogModule\Entities\Car;
use Modules\CatalogModule\Entities\Yacht;

class YachtRepository
{
    public function __construct(Yacht $model)
    {
        $this->model = $model;
    }

    public function listOfYachts(Request $request)
    {
        return $this->model->search($request)
                           ->filter($request)
                           ->active()
                           ->available()
                           ->free()
                           ->with('model')
                           ->whereHas('port', function ($query) { $query->active(); })
                           ->latest()
                           ->paginate($request->get('limit', 20));
    }


    public function findYachtWithDetailsById($yachtId)
    {
        return $this->model->with(['model', 'port', 'plugins' => function ($query) { $query->active(); }])->find($yachtId);
    }
}
