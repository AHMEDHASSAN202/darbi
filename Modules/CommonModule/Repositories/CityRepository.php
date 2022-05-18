<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Repositories;

use Illuminate\Http\Request;
use Modules\CommonModule\Entities\City;

class CityRepository
{
    private $model;

    public function __construct(City $model)
    {
        $this->model = $model;
    }

    public function list(Request $request)
    {
        $query = $this->model->active()->search($request)->filter($request);

        if ($embedParam = $request->get('embed')) {
            $embed = explode(',', $embedParam);
            if (in_array('country', $embed)) {
                $query->with('country');
            }
        }

        if ($request->has('paginated')) {
            return $query->paginate($request->get('limit', 20));
        }

        return $query->get();
    }
}
