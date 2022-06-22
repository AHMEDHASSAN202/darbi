<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

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

    public function listOfVendors($limit = 20)
    {
        return $this->list($limit, 'adminSearch');
    }

    public function findOne($vendorId)
    {
        return $this->model->with('country')->findOrFail(new ObjectId($vendorId));
    }
}
