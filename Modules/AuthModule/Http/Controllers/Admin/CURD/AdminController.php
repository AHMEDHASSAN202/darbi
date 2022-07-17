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
        $result = $this->adminService->findAll($request);

        return $this->apiResponse(...$result);
    }


    public function show($adminId)
    {
        $result = $this->adminService->find($adminId);

        return $this->apiResponse(...$result);
    }


    public function store(CreateAdminRequest $createAdminRequest)
    {
        $result = $this->adminService->create($createAdminRequest);

        return $this->apiResponse(...$result);
    }


    public function update($adminId, UpdateAdminRequest $updateAdminRequest)
    {
        $result = $this->adminService->update($adminId, $updateAdminRequest);

        return $this->apiResponse(...$result);
    }


    public function updatePassword($adminId, UpdateAdminPasswordRequest $updateAdminPasswordRequest)
    {
        $result = $this->adminService->updatePassword($adminId, $updateAdminPasswordRequest);

        return $this->apiResponse(...$result);
    }


    public function destroy($adminId)
    {
        $result = $this->adminService->destroy($adminId);

        return $this->apiResponse(...$result);
    }


    public function getVendorAdminToken($vendorId)
    {
        $result = $this->adminService->getVendorAdminToken($vendorId);

        return $this->apiResponse(...$result);
    }


    public function findAllIds(Request $request)
    {
        $result = $this->adminService->findAllIds($request);

        return $this->apiResponse(...$result);
    }
}
