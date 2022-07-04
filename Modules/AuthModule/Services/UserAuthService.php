<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Services;

use Illuminate\Support\Facades\Log;
use Modules\AuthModule\Events\AfterUserLoginEvent;
use Modules\AuthModule\Http\Requests\User\SendOtpRequest;
use Modules\AuthModule\Http\Requests\User\SigninRequest;
use Modules\AuthModule\Http\Requests\User\SigninWithOtpRequest;
use Modules\AuthModule\Jobs\SendOtpJob;
use Modules\AuthModule\Repositories\User\UserRepository;
use Modules\AuthModule\Transformers\UserProfileResource;
use Modules\CommonModule\Repositories\CountryRepository;

class UserAuthService
{
    private $authGuard = 'api';
    private $userRepository;
    private $countryRepository;

    public function __construct(UserRepository $userRepository, CountryRepository $countryRepository)
    {
        $this->userRepository = $userRepository;
        $this->countryRepository = $countryRepository;
    }


    public function signin(SigninRequest $signinRequest)
    {
        $response['data'] = [];
        $response['statusCode'] = 200;
        $response['message'] = null;
        $response['errors'] = [];

        //get user if exists
        $user = $this->userRepository->findByMobile($signinRequest->phone, $signinRequest->phone_code);

        //if not exists
        //we will create new user with otp
        if (!$user) {
            $user = $this->userRepository->createUserFromSignin($signinRequest->phone, $signinRequest->phone_code);
        }

        //when can't create new user
        if (!$user) {
            Log::error("(singin) can't get user by mobile and can't create it");
            $response['statusCode'] = 500;
            return $response;
        }

        //updated verification code
        if (!$user->verification_code) {
            $user->verification_code = generateOTPCode();
            $user->save();
        }

        //sendOTP
        //we will execute this code after response as a background job
        SendOtpJob::dispatch($user->phone, $user->phone_code, $user->verification_code)->afterResponse();

        $response['message'] = __('OTP is successfully sent');

        return $response;
    }


    public function sendOtp(SendOtpRequest $sendOtpRequest)
    {
        $response['data'] = [];
        $response['statusCode'] = 200;
        $response['message'] = null;
        $response['errors'] = [];

        //get user if exists
        $user = $this->userRepository->findByMobile($sendOtpRequest->phone, $sendOtpRequest->phone_code);

        if (!$user) {
            $response['statusCode'] = 422;
            $response['message'] = __('Mobile not found');
            return $response;
        }

        //sendOTP
        //we will execute this code after response as a background job
        SendOtpJob::dispatch($user->phone, $user->phone_code, $user->verification_code)->afterResponse();

        $response['message'] = __('OTP is successfully sent');

        return $response;
    }


    public function signInWithOTP(SigninWithOtpRequest $signinWithOtpRequest)
    {
        $response['data'] = [];
        $response['statusCode'] = 200;
        $response['message'] = null;
        $response['errors'] = [];

        //get user if exists
        $me = $this->userRepository->findByMobile($signinWithOtpRequest->phone, $signinWithOtpRequest->phone_code);

        //if invalid otp
        if (!$me || ($me->verification_code != $signinWithOtpRequest->otp)) {
            $response['statusCode'] = 422;
            $response['message'] = __('Invalid OTP');
            return $response;
        }

        //if user blocked
        if ($me->isNotActive()) {
            $response['statusCode'] = 422;
            $response['message'] = __('Your account has been locked. Contact your support person to unlock it, then try again.');
            return $response;
        }

        $me->last_login = now();
        $me->verification_code = null;
        $me->save();

        $response['statusCode'] = 200;
        $response['data'] = [
            'profile'           => new UserProfileResource($me),
            'token'             => auth($this->authGuard)->login($me)
        ];

        //dispatch event after login
        event(new AfterUserLoginEvent($me));

        return $response;
    }


    public function authUser()
    {
        return auth($this->authGuard)->user();
    }
}
