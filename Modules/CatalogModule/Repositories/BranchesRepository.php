<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Modules\CatalogModule\Entities\Branch;
use MongoDB\BSON\ObjectId;

class BranchesRepository
{
    public function __construct(Branch $model)
    {
        $this->model = $model;
    }

    public function findAllBranchesByRegion($regionId, $isOpen = null)
    {
        return $this->model->where('region_ids', 'all', [new ObjectId($regionId)])->when($isOpen, function ($q) { $q->opened(); })->active()->get();
    }
}
