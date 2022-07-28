<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Repositories;

use Illuminate\Http\Request;
use Modules\CommonModule\Entities\City;
use MongoDB\BSON\ObjectId;

class CityRepository
{
    private $model;

    public function __construct(City $model)
    {
        $this->model = $model;
    }

    public function list(Request $request)
    {
        return $this->model->active()->search($request)->filter($request)->whereHas('country', function ($query) { $query->active(); })->paginated();
    }

    public function find($id)
    {
        return $this->model->active()->where('_id', new ObjectId($id))->firstOrFail();
    }

    public function findAllForDashboard(Request $request)
    {
        return $this->model->search($request)->filter($request)->with('country')->paginated();
    }

    public function toggleActive($cityId)
    {
        $city = $this->model->findOrFail($cityId);
        $city->is_active = !$city->is_active;
        $city->save();

        return $city;
    }
}
