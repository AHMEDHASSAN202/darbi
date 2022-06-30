<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Repositories\Admin;

use Illuminate\Http\Request;
use Modules\AuthModule\Entities\Admin;
use MongoDB\BSON\ObjectId;

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

    public function list(Request $request, $type = 'admin', $limit = 20)
    {
        $meId = auth('admin_api')->id();

        return $this->model->search($request)->filter($request)->with('role')->where('_id', '!=', new ObjectId($meId))->where('type', $type)->paginate($limit);
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
        $meId = auth('admin_api')->id();

        return $this->model->with('role')->where('_id', '!=', new ObjectId($meId))->findOrFail($id);
    }

    public function findByEmail($email, $type, $with = [])
    {
        return $this->model->where('email', $email)->where('type', $type)->with($with)->first();
    }
}
