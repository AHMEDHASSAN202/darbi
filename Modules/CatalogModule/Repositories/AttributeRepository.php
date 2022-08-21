<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Illuminate\Http\Request;
use Modules\CatalogModule\Entities\Attribute;
use MongoDB\BSON\ObjectId;

class AttributeRepository
{
    public function __construct(Attribute $model)
    {
        $this->model = $model;
    }

    public function findAll(Request $request)
    {
        return $this->model->filters($request)->latest()->paginated();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($data, $id)
    {
        return $this->model->where('_id', new ObjectId($id))->firstOrFail()->update($data);
    }

    public function destroy($id)
    {
        return $this->model->destroy($id);
    }

    public function find($id)
    {
        return $this->model->where('_id', new ObjectId($id))->firstOrFail();
    }

    public function findByIds(array $ids)
    {
        return $this->model->whereIn('_id', generateObjectIdOfArrayValues($ids))->get();
    }
}
