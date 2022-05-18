<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Modules\CatalogModule\Entities\Vendor;
use Modules\CommonModule\Traits\CrudRepositoryTrait;

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
