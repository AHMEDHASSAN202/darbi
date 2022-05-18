<?php

namespace Modules\AuthModule\Http\Controllers\Admin;


use Illuminate\Routing\Controller;
use Modules\AuthModule\Http\Requests\Admin\LoginToAdminRequest;
use Modules\AuthModule\Services\AuthAdminService;
use Modules\CommonModule\Traits\ApiResponseTrait;

/**
 * @group Auth Dashboard
 *
 */
class AuthAdminController extends Controller
{
    use ApiResponseTrait;

    private $authAdminService;


    public function __construct(AuthAdminService $authAdminService)
    {
        $this->authAdminService = $authAdminService;
    }

    /**
     * Login Admin
     *
     * Login admin request. If everything is okay, you'll get a 200 OK response and user access token.
     * Otherwise, the request will fail with a 400 || 422 || 401 || 500 error
     * @bodyParam email string required the admin mail.
     * @bodyParam password string required the admin password.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginToAdminRequest $loginToDashboardRequest)
    {
        $result = $this->authAdminService->login($loginToDashboardRequest);

        return $this->apiResponse($result['data'], $result['statusCode'], $result['message'], @$result['errors']);
    }
}
