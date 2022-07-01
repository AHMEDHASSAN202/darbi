<?php

namespace Modules\AuthModule\Http\Controllers\Admin\Role;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AuthModule\Http\Requests\Admin\CreateRoleRequest;
use Modules\AuthModule\Http\Requests\Admin\UpdateRoleRequest;
use Modules\AuthModule\Services\RoleService;
use Modules\CommonModule\Traits\ApiResponseTrait;
use function __;


class RoleController extends Controller
{
    use ApiResponseTrait;

    private $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }


    public function index(Request $request)
    {
        $roles = $this->roleService->findAll($request);

        return $this->apiResponse(compact('roles'));
    }


    public function show($roleId)
    {
        return $this->apiResponse([
            'role'      => $this->roleService->find($roleId)
        ]);
    }

    public function store(CreateRoleRequest $createRoleRequest)
    {
        $role = $this->roleService->createRole($createRoleRequest);

        return $this->apiResponse(compact('role'), 201, __('Data has been added successfully'));
    }


    public function update($roleId, UpdateRoleRequest $updateRoleRequest)
    {
        $role = $this->roleService->updateRole($roleId, $updateRoleRequest);

        return $this->apiResponse(compact('role'), 200, __('Data has been updated successfully'));
    }


    public function destroy($roleId)
    {
        $result = $this->roleService->destroyRole($roleId);

        return $this->apiResponse($result['data'], $result['statusCode'], $result['message']);
    }


    public function findVendorRole()
    {
        return $this->apiResponse([
            'role'      => $this->roleService->findVendorRole()
        ]);
    }
}
