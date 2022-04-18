<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AdminModule\Services;

use Modules\AdminModule\Repositories\RoleRepository;
use Modules\AdminModule\Transformers\RoleCollection;
use Modules\AdminModule\Transformers\RoleResource;
use Modules\CommonModule\Transformers\PaginateResource;


class RoleService
{
    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getList($request)
    {
        $limit = $request->get('limit', 20);
        $roles = $this->roleRepository->list($limit, 'adminSearch');

        return new PaginateResource(RoleResource::collection($roles));
    }

    public function createRole($request)
    {
        $role = $this->roleRepository->create(['name' => $request->name, 'permissions' => json_encode($request->permissions), 'guard' => 'admin_api']);

        return new RoleResource($role);
    }

    public function updateRole($roleId, $request)
    {
        $role = $this->roleRepository->update($roleId, ['name' => $request->name, 'permissions' => json_encode($request->permissions)]);

        return  new RoleResource($role);
    }

    public function destroyRole($roleId)
    {
        $role = $this->roleRepository->find($roleId);

        //check if users related to this role
        //we will prevent deleting
        if ($role->admins()->count()) {
            return $this->apiResponse([], 422, __('Deletion is not allowed'));
        }

        return $role->delete();
    }
}
