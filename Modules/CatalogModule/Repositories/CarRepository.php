<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Illuminate\Http\Request;
use Modules\CatalogModule\Entities\Car;

class CarRepository
{
    public function __construct(Car $model)
    {
        $this->model = $model;
    }

    public function listOfCars(Request $request)
    {
        return $this->model->search($request)
                           ->with(['model', 'brand'])
                           ->filter($request)
                           ->active()
                           ->whereHas('model', function ($query) { $query->active(); })
                           ->whereHas('brand', function ($query) { $query->active(); })
                           ->available()
                           ->free()
                           ->latest()
                           ->paginate($request->get('limit', 20));
    }


    public function findCarWithDetailsById($carId)
    {
        return $this->model->with(['model', 'brand', 'plugins' => function ($query) { $query->active(); }])->find($carId);
    }
}
