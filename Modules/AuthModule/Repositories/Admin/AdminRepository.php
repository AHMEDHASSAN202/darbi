<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Repositories\Admin;

use Illuminate\Http\Request;
use Modules\AuthModule\Entities\Admin;

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

    public function list(Request $request, $limit = 20)
    {
        //get all
        return $this->model->search($request)->with('role:id,name')->paginate($limit);
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
