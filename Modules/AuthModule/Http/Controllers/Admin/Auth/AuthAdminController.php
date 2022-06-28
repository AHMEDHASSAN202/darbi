<?php

namespace Modules\AuthModule\Http\Controllers\Admin\Auth;


use Illuminate\Routing\Controller;
use Modules\AuthModule\Http\Requests\Admin\LoginToAdminRequest;
use Modules\AuthModule\Services\AdminAuthService;
use Modules\CommonModule\Traits\ApiResponseTrait;

/**
 * @group Auth Dashboard
 *
 */
class AuthAdminController extends Controller
{
    use ApiResponseTrait;

    private $authAdminService;


    public function __construct(AdminAuthService $authAdminService)
    {
        $this->authAdminService = $authAdminService;
    }


    public function login(LoginToAdminRequest $loginToDashboardRequest)
    {
        $result = $this->authAdminService->login($loginToDashboardRequest, 'admin');

        return $this->apiResponse($result['data'], $result['statusCode'], $result['message'], @$result['errors']);
    }
}
