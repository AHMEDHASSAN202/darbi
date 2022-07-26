<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        return $this->model->search($request)->filter($request)->latest()->with(['country' => function ($q) { $q->withTrashed(); }, 'createdBy' => function ($q) { $q->withTrashed(); }])->paginated();
    }

    public function findOne($vendorId)
    {
        return $this->model->findOrFail(new ObjectId($vendorId));
    }

    public function toggleActive($vendorId)
    {
        $vendor = $this->model->findOrFail(new ObjectId($vendorId));
        $vendor->is_active = !$vendor->is_active;
        $vendor->save();

        return $vendor;
    }
}
