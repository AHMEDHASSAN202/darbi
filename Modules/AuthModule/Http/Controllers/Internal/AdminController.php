<?php

namespace Modules\AuthModule\Http\Controllers\Internal;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AuthModule\Services\AdminService;
use Modules\CommonModule\Traits\ApiResponseTrait;

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

    public function findAllIds(Request $request)
    {
        $result = $this->adminService->findAllIds($request);

        return $this->apiResponse(...$result);
    }

    public function getVendorAdminToken($vendorId)
    {
        $result = $this->adminService->getVendorAdminToken($vendorId);

        return $this->apiResponse(...$result);
    }
}
