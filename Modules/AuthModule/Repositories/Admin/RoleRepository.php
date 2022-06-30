<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Repositories\Admin;

use Illuminate\Http\Request;
use Modules\AuthModule\Entities\Role;

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


    public function list(Request $request, $limit = 20)
    {
        return $this->model->adminSearch($request)->adminFilter($request)->paginate($limit);
    }


    public function update($id, $data)
    {
        $role = $this->model->findOrFail($id);
        $role->update($data);
        $role->refresh();
        return $role;
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
