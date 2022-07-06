<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Illuminate\Http\Request;
use Modules\CatalogModule\Entities\Brand;
use Modules\CommonModule\Traits\CrudRepositoryTrait;

class BrandRepository
{
    use CrudRepositoryTrait;

    public function __construct(Brand $model)
    {
        $this->model = $model;
    }

    public function listOfBrands(Request $request)
    {
        return $this->model->search($request)->filters($request)->active()->latest()->paginated();
    }

    public function listOfBrandsForDashboard(Request $request, $wheres = [])
    {
        return $this->model->adminSearch($request)->adminFilters($request)->latest()->where($wheres)->paginated();
    }
}
