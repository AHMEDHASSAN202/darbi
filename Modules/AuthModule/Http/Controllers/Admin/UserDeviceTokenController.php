<?php

namespace Modules\AuthModule\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AuthModule\Http\Requests\StoreDeviceTokenRequest;
use Modules\AuthModule\Services\UserDeviceTokenService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class UserDeviceTokenController extends Controller
{
    use ApiResponseTrait;

    private $userDeviceTokenService;


    public function __construct(UserDeviceTokenService $userDeviceTokenService)
    {
        $this->userDeviceTokenService = $userDeviceTokenService;
    }


    public function index(Request $request)
    {
        $result = $this->userDeviceTokenService->findAll($request);

        return $this->apiResponse(...$result);
    }



    public function storeDeviceToken(StoreDeviceTokenRequest $storeDeviceTokenRequest)
    {
        $result = $this->userDeviceTokenService->handleAdminDeviceToken($storeDeviceTokenRequest);

        return $this->apiResponse(...$result);
    }
}
