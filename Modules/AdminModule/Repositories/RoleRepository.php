<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AdminModule\Repositories;

use Modules\AdminModule\Entities\Role;

class RoleRepository
{
    private $model;

    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function list($limit = 20, $searchMethod = null, $moreScopeMethod = null)
    {
        $query = $this->model;

        if ($searchMethod) {
            $query = $query->{$searchMethod}();
        }

        if ($moreScopeMethod) {
            $query = $query->{$moreScopeMethod}();
        }

        //get with pagination
        if ($limit != 0) {
            return $query->paginate($limit);
        }

        //get all
        return $query->get();
    }

    public function update($id, $data)
    {
        return $this->model->find($id)->update($data);
    }

    public function destroy($id)
    {
        return $this->model->find($id)->delete();
    }
}
