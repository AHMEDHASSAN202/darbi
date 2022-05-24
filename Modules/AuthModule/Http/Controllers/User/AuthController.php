<?php

namespace Modules\AuthModule\Http\Controllers\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AuthModule\Http\Requests\User\SendOtpRequest;
use Modules\AuthModule\Http\Requests\User\SigninRequest;
use Modules\AuthModule\Http\Requests\User\SigninWithOtpRequest;
use Modules\AuthModule\Services\UserAuthService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class AuthController extends Controller
{
    use ApiResponseTrait;

    private $userAuthService;

    public function __construct(UserAuthService $userAuthService)
    {
        $this->userAuthService = $userAuthService;
    }


    public function signin(SigninRequest $signinRequest)
    {
        $result = $this->userAuthService->signin($signinRequest);

        return $this->apiResponse(
            $result['data'], $result['statusCode'], $result['message'], $result['errors']
        );
    }


    public function sendOtp(SendOtpRequest $sendOtpRequest)
    {
        $result = $this->userAuthService->sendOtp($sendOtpRequest);

        return $this->apiResponse(
            $result['data'], $result['statusCode'], $result['message'], $result['errors']
        );
    }


    public function signinWithOtp(SigninWithOtpRequest $signinWithOtpRequest)
    {
        $result = $this->userAuthService->signInWithOTP($signinWithOtpRequest);

        return $this->apiResponse(
            $result['data'], $result['statusCode'], $result['message'], $result['errors']
        );
    }
}
