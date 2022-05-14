<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\VendorModule\Repositories;

use Modules\CommonModule\Traits\CrudRepositoryTrait;
use Modules\VendorModule\Entities\Vendor;

class VendorRepository
{
    use CrudRepositoryTrait;

    public function __construct(Vendor $model)
    {
        $this->model = $model;
    }

    public function listOfVendors($limit = 20)
    {
        return $this->list($limit, 'adminSearch');
    }
}
