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
        return $this->model->active()->filter($request)->search($request)->get();
    }

    public function find($countryId)
    {
        return $this->model->active()->findOrFail($countryId);
    }

    public function findAllForDashboard(Request $request)
    {
        return $this->model->filter($request)->search($request)->get();
    }

    public function toggleActive($countryId)
    {
        $country = $this->model->findOrFail($countryId);
        $country->is_active = !$country->is_active;
        $country->save();

        return $country;
    }

    public function findForDashboard($countryId)
    {
        return $this->model->findOrFail($countryId);
    }
}
