<?php

namespace Modules\AuthModule\Http\Controllers\Admin\Auth;

use Illuminate\Routing\Controller;
use Modules\AuthModule\Http\Requests\Admin\LoginToAdminRequest;
use Modules\AuthModule\Services\AdminAuthService;
use Modules\CommonModule\Traits\ApiResponseTrait;

/**
 * @group Auth Vendor
 *
 */
class AuthVendorController extends Controller
{
    use ApiResponseTrait;

    private $adminAuthService;


    public function __construct(AdminAuthService $adminAuthService)
    {
        $this->adminAuthService = $adminAuthService;
    }


    public function login(LoginToAdminRequest $loginToDashboardRequest)
    {
        $result = $this->adminAuthService->login($loginToDashboardRequest, 'vendor');

        return $this->apiResponse($result['data'], $result['statusCode'], $result['message'], @$result['errors']);
    }
}
