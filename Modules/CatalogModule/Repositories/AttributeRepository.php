<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Illuminate\Http\Request;
use Modules\CatalogModule\Entities\Attribute;
use Modules\CatalogModule\Entities\Branch;
use Modules\CommonModule\Traits\CrudRepositoryTrait;
use MongoDB\BSON\ObjectId;

class AttributeRepository
{
    public function __construct(Attribute $model)
    {
        $this->model = $model;
    }

    public function findAll(Request $request)
    {
        return $this->model->filters($request)->get();
    }
}
