<?php

namespace Modules\AuthModule\Http\Controllers\User;


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


    public function storeDeviceToken(StoreDeviceTokenRequest $storeDeviceTokenRequest)
    {
        $result = $this->userDeviceTokenService->handleUserDeviceToken($storeDeviceTokenRequest);

        return $this->apiResponse(...$result);
    }
}
