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

    /**
     * List of admins
     *
     * @queryParam q string
     * get admins. If everything is okay, you'll get a 200 OK response.
     * Otherwise, the request will fail with a 400 || 422 || 500 error
     */
    public function index(Request $request)
    {
        $admins = $this->adminService->findAll($request);

        return $this->apiResponse(compact('admins'));
    }

    /**
     * Create admin
     *
     * @bodyParam role_id int required
     * @bodyParam name string required
     * @bodyParam email string required
     * @bodyParam password string required
     * @bodyParam password_confirmation string required
     * create new admin. If everything is okay, you'll get a 200 OK response.
     * Otherwise, the request will fail with a 400 || 422 || 500 error
     */
    public function store(CreateAdminRequest $createAdminRequest)
    {
        $admin = $this->adminService->create($createAdminRequest);

        return $this->apiResponse(compact('admin'), 201, __('Data has been added successfully'));
    }

    /**
     * Update Admin
     *
     * @param $adminId
     * @bodyParam role_id int required
     * @bodyParam name string required
     * @bodyParam email string required
     * update admin. If everything is okay, you'll get a 200 OK response.
     * Otherwise, the request will fail with a 400 || 422 || 500 error
     */
    public function update($adminId, UpdateAdminRequest $updateAdminRequest)
    {
        $admin = $this->adminService->update($adminId, $updateAdminRequest);

        return $this->apiResponse(compact('admin'), 200, __('Data has been updated successfully'));
    }

    /**
     * Update admin password
     *
     * @param $adminId
     * @param UpdateAdminPasswordRequest $updateAdminPasswordRequest
     * @bodyParam password string required
     * @bodyParam password_confirmation string required
     * update admin password. If everything is okay, you'll get a 200 OK response.
     * Otherwise, the request will fail with a 400 || 422 || 500 error
     */
    public function updatePassword($adminId, UpdateAdminPasswordRequest $updateAdminPasswordRequest)
    {
        $admin = $this->adminService->updatePassword($adminId, $updateAdminPasswordRequest);

        return $this->apiResponse(compact('admin'), 200, __('Data has been updated successfully'));
    }

    /**
     * Delete admin
     *
     * @param $adminId
     * delete admin. If everything is okay, you'll get a 200 OK response.
     * Otherwise, the request will fail with a 400 || 422 || 500 error
     */
    public function destroy($adminId)
    {
        $this->adminService->destroy($adminId);

        return $this->apiResponse([], 200, __('Data has been deleted successfully'));
    }
}
