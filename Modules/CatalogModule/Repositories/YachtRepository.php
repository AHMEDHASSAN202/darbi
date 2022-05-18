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
                           ->whereHas('port', function ($query) { $query->active(); })
                           ->with('plugins')
                           ->latest()
                           ->paginate($request->get('limit', 20));
    }
}
