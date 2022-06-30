<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Illuminate\Http\Request;
use Modules\CatalogModule\Entities\Branch;
use Modules\CommonModule\Traits\CrudRepositoryTrait;
use MongoDB\BSON\ObjectId;

class BranchRepository
{
    use CrudRepositoryTrait;

    public function __construct(Branch $model)
    {
        $this->model = $model;
    }

    public function findAllBranchesByRegion($regionId, $isOpen = null)
    {
        return $this->model->where('region_id', new ObjectId($regionId))->when($isOpen, function ($q) { $q->opened(); })->active()->get();
    }

    public function findAllBranchesByCity($cityId, $isOpen = null)
    {
        return $this->model->where('city_id', new ObjectId($cityId))->when($isOpen, function ($q) { $q->opened(); })->active()->get();
    }

    public function findAllByVendor(ObjectId $vendorId, Request $request)
    {
        $query = $this->model->where('vendor_id', $vendorId)->adminSearch($request)->adminFilters($request)->latest();

        if ($request->has('paginated')) {
            return $query->paginate($request->get('limit', 20));
        }

        return $query->get();
    }

    public function findByVendor(ObjectId $vendorId, ObjectId $branchId)
    {
        return $this->model->where('vendor_id', $vendorId)->where('_id', $branchId)->with('city')->firstOrFail();
    }
}
