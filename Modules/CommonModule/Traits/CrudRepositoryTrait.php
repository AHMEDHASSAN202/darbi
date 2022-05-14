<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Traits;

trait CrudRepositoryTrait
{
    private $model;

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($id, $data)
    {
        $row = $this->model->findOrFail($id);
        $row->update($data);
        $row->refresh();
        return $row;
    }

    public function destroy($id)
    {
        return $this->model->findOrFail($id)->delete();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function list($limit = 20, $searchMethod = null, $moreScopeMethod = null, $with = [])
    {
        //model instance
        $query = $this->model;

        //search scope method
        if ($searchMethod) {
            $query = $query->{$searchMethod}();
        }

        //more filter scope
        if ($moreScopeMethod) {
            $query = $query->{$moreScopeMethod}();
        }

        //handle relations
        if (!empty($with)) {
            $query->with($with);
        }

        //get with pagination
        if ($limit) {
            return $query->paginate($limit);
        }

        //get all
        return $query->get();
    }
}
