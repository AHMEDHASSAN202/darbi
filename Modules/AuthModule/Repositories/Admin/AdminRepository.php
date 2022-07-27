<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Repositories\Admin;

use Illuminate\Http\Request;
use Modules\AuthModule\Entities\Admin;
use Modules\AuthModule\Entities\SuperAdmin;
use Modules\AuthModule\Entities\VendorAdmin;
use MongoDB\BSON\ObjectId;

class AdminRepository
{
    private $model;
    private $superAdminModel;
    private $vendorAdminModel;

    public function __construct(Admin $admin, SuperAdmin $superAdmin, VendorAdmin $vendorAdmin)
    {
        $this->model = $admin;
        $this->superAdminModel = $superAdmin;
        $this->vendorAdminModel = $vendorAdmin;
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function list(Request $request)
    {
        $meId = auth('admin_api')->id();

        return $this->model->search($request)->filter($request)->latest()->with(['role', 'vendor' => function ($q) { $q->withTrashed(); }])->where('_id', '!=', new ObjectId($meId))->paginated();
    }

    public function findAllIds(Request $request)
    {
        return $this->model->search($request)->filter($request)->latest()->paginated();
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
        if ($type == 'admin') {

            return $this->superAdminModel->where('email', $email)->with($with)->first();

        }elseif ($type == 'vendor') {

            return $this->vendorAdminModel->where('email', $email)->with($with)->first();
        }

        return null;
    }

    public function countAdminFromThisRole($roleId)
    {
        return $this->model->where('role_id', new ObjectId($roleId))->count();
    }

    public function getVendorAdmin($vendorId)
    {
        return $this->vendorAdminModel->where('vendor_id', new ObjectId($vendorId))->whereHas('role', function ($q) { $q->where('key', config('authmodule.default_vendor_role')); })->first();
    }
}
