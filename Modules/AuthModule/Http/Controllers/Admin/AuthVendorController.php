<?php

namespace Modules\AuthModule\Http\Controllers\Admin;

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

    /**
     * Login Vendor
     *
     * Login vendor request. If everything is okay, you'll get a 200 OK response and user access token.
     * Otherwise, the request will fail with a 400 || 422 || 401 || 500 error
     * @bodyParam email string required the vendor mail.
     * @bodyParam password string required the vendor password.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginToAdminRequest $loginToDashboardRequest)
    {
        $result = $this->adminAuthService->login($loginToDashboardRequest);

        return $this->apiResponse($result['data'], $result['statusCode'], $result['message'], @$result['errors']);
    }
}
