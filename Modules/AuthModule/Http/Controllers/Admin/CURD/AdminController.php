<?php

namespace Modules\AuthModule\Http\Controllers\Admin\CURD;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AuthModule\Http\Requests\Admin\CreateAdminRequest;
use Modules\AuthModule\Http\Requests\Admin\UpdateAdminPasswordRequest;
use Modules\AuthModule\Http\Requests\Admin\UpdateAdminRequest;
use Modules\AuthModule\Services\AdminService;
use Modules\CommonModule\Traits\ApiResponseTrait;
use function __;

/**
 * @group Admins
 *
 * Management Admins
 */
class AdminController extends Controller
{
    use ApiResponseTrait;

    private $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }


    public function index(Request $request)
    {
        $admins = $this->adminService->findAll($request);

        return $this->apiResponse(compact('admins'));
    }


    public function show($adminId)
    {
        $admin = $this->adminService->find($adminId);

        return $this->apiResponse(compact('admin'));
    }


    public function store(CreateAdminRequest $createAdminRequest)
    {
        $admin = $this->adminService->create($createAdminRequest);

        return $this->apiResponse(compact('admin'), 201, __('Data has been added successfully'));
    }


    public function update($adminId, UpdateAdminRequest $updateAdminRequest)
    {
        $admin = $this->adminService->update($adminId, $updateAdminRequest);

        return $this->apiResponse(compact('admin'), 200, __('Data has been updated successfully'));
    }


    public function updatePassword($adminId, UpdateAdminPasswordRequest $updateAdminPasswordRequest)
    {
        $admin = $this->adminService->updatePassword($adminId, $updateAdminPasswordRequest);

        return $this->apiResponse(compact('admin'), 200, __('Data has been updated successfully'));
    }


    public function destroy($adminId)
    {
        $result = $this->adminService->destroy($adminId);

        return $this->apiResponse([], $result['statusCode'], $result['message'], $result['errors']);
    }
}
