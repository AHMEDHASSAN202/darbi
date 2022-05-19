<?php

namespace Modules\AuthModule\Http\Controllers\Vendor;

use Illuminate\Routing\Controller;
use Modules\AuthModule\Http\Requests\Admin\LoginToAdminRequest;
use Modules\AuthModule\Services\AuthVendorService;
use Modules\CommonModule\Traits\ApiResponseTrait;

/**
 * @group Auth Vendor
 *
 */
class AuthVendorController extends Controller
{
    use ApiResponseTrait;

    private $authVendorService;


    public function __construct(AuthVendorService $authVendorService)
    {
        $this->authVendorService = $authVendorService;
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
        $result = $this->authVendorService->login($loginToDashboardRequest);

        return $this->apiResponse($result['data'], $result['statusCode'], $result['message'], @$result['errors']);
    }
}
