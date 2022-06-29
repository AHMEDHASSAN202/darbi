<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Illuminate\Http\Request;
use Modules\CatalogModule\Entities\Vendor;
use Modules\CommonModule\Traits\CrudRepositoryTrait;
use MongoDB\BSON\ObjectId;

class VendorRepository
{
    use CrudRepositoryTrait;

    private $model;

    public function __construct(Vendor $model)
    {
        $this->model = $model;
    }

    public function listOfVendors(Request $request)
    {
        $paginated = $request->has('paginated');
        $limit = $request->get('limit', 20);

        $query = $this->model->search($request)->filter($request)->latest()->with('country');

        if ($paginated) {
            return $query->paginate($limit);
        }

        return $query->get();
    }

    public function findOne($vendorId)
    {
        return $this->model->with('country')->findOrFail(new ObjectId($vendorId));
    }
}
