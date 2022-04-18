<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AdminModule\Repositories;

use Modules\AdminModule\Entities\Admin;

class AdminRepository
{
    private $model;

    public function __construct(Admin $admin)
    {
        $this->model = $admin;
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
        return $query->with('role:id,name')->get();
    }

    public function update($id, $data)
    {
        $admin = $this->model->findOrFail($id);
        $admin->update($data);
        $admin->refresh();
        return $admin;
    }

    public function destroy($id)
    {
        return $this->model->findOrFail($id)->delete();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }
}
