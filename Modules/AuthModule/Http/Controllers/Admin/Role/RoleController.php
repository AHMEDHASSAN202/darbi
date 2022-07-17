<?php

namespace Modules\AuthModule\Http\Controllers\Admin\Role;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AuthModule\Http\Requests\Admin\CreateRoleRequest;
use Modules\AuthModule\Http\Requests\Admin\UpdateRoleRequest;
use Modules\AuthModule\Services\RoleService;
use Modules\CommonModule\Traits\ApiResponseTrait;


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
        $result = $this->roleService->findAll($request);

        return $this->apiResponse(...$result);
    }


    public function show($roleId)
    {
        $result = $this->roleService->find($roleId);

        return $this->apiResponse(...$result);
    }


    public function store(CreateRoleRequest $createRoleRequest)
    {
        $result = $this->roleService->createRole($createRoleRequest);

        return $this->apiResponse(...$result);
    }


    public function update($roleId, UpdateRoleRequest $updateRoleRequest)
    {
        $result = $this->roleService->updateRole($roleId, $updateRoleRequest);

        return $this->apiResponse(...$result);
    }


    public function destroy($roleId)
    {
        $result = $this->roleService->destroyRole($roleId);

        return $this->apiResponse(...$result);
    }


    public function findVendorRole()
    {
        $result = $this->roleService->findVendorRole();

        return $this->apiResponse(...$result);
    }
}
