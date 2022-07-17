<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Services;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\AdminModule\Transformers\RoleCollection;
use Modules\AuthModule\Repositories\Admin\AdminRepository;
use Modules\AuthModule\Repositories\Admin\RoleRepository;
use Modules\AuthModule\Transformers\FindRoleResource;
use Modules\AuthModule\Transformers\RoleResource;
use Modules\CommonModule\Transformers\PaginateResource;


class RoleService
{
    private $roleRepository;
    private $adminRepository;

    public function __construct(RoleRepository $roleRepository, AdminRepository $adminRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->adminRepository = $adminRepository;
    }

    public function findAll(Request $request)
    {
        $roles = $this->roleRepository->list($request);

        if ($roles instanceof LengthAwarePaginator) {
            return successResponse(['roles' => new PaginateResource(RoleResource::collection($roles))]);
        }

        return successResponse(['roles' => RoleResource::collection($roles)]);
    }

    public function find($roleId)
    {
        $role = $this->roleRepository->find($roleId);

        return successResponse(['role' => new FindRoleResource($role)]);
    }

    public function findVendorRole()
    {
        $role = $this->roleRepository->findVendorRole();

        return successResponse(['role' => new FindRoleResource($role)]);
    }

    public function createRole($request)
    {
        $role = $this->roleRepository->create(['name' => $request->name, 'permissions' => json_encode($request->permissions), 'guard' => $request->guard]);

        return createdResponse(['role' => new FindRoleResource($role)]);
    }

    public function updateRole($roleId, $request)
    {
        $role = $this->roleRepository->update($roleId, ['name' => $request->name, 'permissions' => json_encode($request->permissions)]);

        return  updatedResponse(['role' => new FindRoleResource($role)]);
    }

    public function destroyRole($roleId)
    {
        $role = $this->roleRepository->find($roleId);

        //check if users related to this role
        //we will prevent deleting
        if ($this->adminRepository->countAdminFromThisRole($roleId)) {
            return badResponse([], __('Deletion is not allowed'));
        }

        $role->delete();

        return deletedResponse();
    }
}
