<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Illuminate\Http\Request;
use Modules\CatalogModule\Entities\Brand;

class BrandRepository
{
    public function __construct(Brand $model)
    {
        $this->model = $model;
    }

    public function listOfBrands(Request $request)
    {
        $query = $this->model->search($request)
                             ->filters($request)
                             ->active()
                             ->latest();

        if ($request->has('paginated')) {
            return $query->paginate($request->get('limit', 20));
        }

        return $query->get();
    }
}
