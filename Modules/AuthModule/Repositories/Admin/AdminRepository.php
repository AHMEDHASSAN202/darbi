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

    public function list(Request $request, $limit = 20)
    {
        $meId = auth('admin_api')->id();

        return $this->model->search($request)->filter($request)->latest()->with(['role', 'vendor' => function ($q) { $q->withTrashed(); }])->where('_id', '!=', new ObjectId($meId))->paginate($limit);
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

    public function find($id, $with = ['role'])
    {
        $meId = auth('admin_api')->id();

        return $this->model->with($with)->where('_id', '!=', new ObjectId($meId))->findOrFail($id);
    }

    public function findByEmail($email, $type, $with = [])
    {
        return $this->model->where('email', $email)->where('type', $type)->with($with)->first();
    }

    public function countAdminFromThisRole($roleId)
    {
        return $this->model->where('role_id', new ObjectId($roleId))->count();
    }

    public function getVendorAdmin($vendorId)
    {
        return $this->model->where('vendor_id', new ObjectId($vendorId))->where('type', 'vendor')->whereHas('role', function ($q) { $q->where('key', config('authmodule.default_vendor_role')); })->first();
    }
}
