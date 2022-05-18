<?php

namespace Modules\AuthModule\Http\Controllers\Role;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AuthModule\Services\RoleService;
use Modules\AuthModule\Requests\Role\CreateRoleRequest;
use Modules\AuthModule\Requests\Role\UpdateRoleRequest;
use Modules\CommonModule\Traits\ApiResponseTrait;

/**
 * @group Roles
 *
 * Management Roles
 */
class RoleController extends Controller
{
    use ApiResponseTrait;

    private $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * List of roles
     *
     * @queryParam q string
     * get roles. If everything is okay, you'll get a 200 OK response.
     * Otherwise, the request will fail with a 400 || 422 || 500 error
     */
    public function index(Request $request)
    {
        $roles = $this->roleService->findAll($request);

        return $this->apiResponse(compact('roles'));
    }

    /**
     * Create Role
     *
     * @bodyParam name string required
     * @bodyParam permissions array required
     * create new role. If everything is okay, you'll get a 200 OK response.
     * Otherwise, the request will fail with a 400 || 422 || 500 error
     */
    public function store(CreateRoleRequest $createRoleRequest)
    {
        $role = $this->roleService->createRole($createRoleRequest);

        return $this->apiResponse(compact('role'), 201, __('Data has been added successfully'));
    }

    /**
     * Update Role
     *
     * @param $roleId
     * @bodyParam name string required
     * @bodyParam permissions array required
     * update role. If everything is okay, you'll get a 200 OK response.
     * Otherwise, the request will fail with a 400 || 422 || 500 error
     */
    public function update($roleId, UpdateRoleRequest $updateRoleRequest)
    {
        $role = $this->roleService->updateRole($roleId, $updateRoleRequest);

        return $this->apiResponse(compact('role'), 200, __('Data has been updated successfully'));
    }

    /**
     * Delete Role
     *
     * @param $roleId
     * delete role. If everything is okay, you'll get a 200 OK response.
     * Otherwise, the request will fail with a 400 || 422 || 500 error
     */
    public function destroy($roleId)
    {
        $this->roleService->destroyRole($roleId);

        return $this->apiResponse([], 200, __('Data has been deleted successfully'));
    }
}
