<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Repositories;

use Illuminate\Http\Request;
use Modules\CommonModule\Entities\Country;

class CountryRepository
{
    private $model;

    public function __construct(Country $model)
    {
        $this->model = $model;
    }

    public function list(Request $request)
    {
        return $this->model->active()->search($request)->get();
    }

    public function find($countryId)
    {
        return $this->model->active()->find($countryId);
    }
}
