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
use Modules\AuthModule\Repositories\User\OTPVerificationCodeRepository;
use Modules\AuthModule\Repositories\User\UserRepository;
use Modules\AuthModule\Transformers\UserProfileResource;
use Modules\CommonModule\Repositories\CountryRepository;

class UserAuthService
{
    private $authGuard = 'api';
    private $userRepository;
    private $countryRepository;
    private $OTPVerificationCodeRepository;

    public function __construct(UserRepository $userRepository, CountryRepository $countryRepository, OTPVerificationCodeRepository $OTPVerificationCodeRepository)
    {
        $this->userRepository = $userRepository;
        $this->countryRepository = $countryRepository;
        $this->OTPVerificationCodeRepository = $OTPVerificationCodeRepository;
    }


    public function signin(SigninRequest $signinRequest)
    {
        $response['data'] = [];
        $response['statusCode'] = 200;
        $response['message'] = null;
        $response['errors'] = [];

        //get otp if exists
        $otp = $this->OTPVerificationCodeRepository->findByMobileAndCode($signinRequest->phone, $signinRequest->phone_code);

        //if not exists
        //we will create new otp
        if (!$otp) {
            $otp = $this->OTPVerificationCodeRepository->createNewOTP($signinRequest->phone, $signinRequest->phone_code);
        }

        //when can't create new user
        if (!$otp) {
            Log::error("(singin) can't get otp by mobile and can't create it");
            $response['statusCode'] = 500;
            return $response;
        }

        //sendOTP
        //we will execute this code after response as a background job
        SendOtpJob::dispatch($otp->phone, $otp->phone_code, $otp->verification_code)->afterResponse();

        $response['message'] = __('OTP is successfully sent');

        return $response;
    }


    public function sendOtp(SendOtpRequest $sendOtpRequest)
    {
        $response['data'] = [];
        $response['statusCode'] = 200;
        $response['message'] = null;
        $response['errors'] = [];

        //get otp if exists
        $otp = $this->OTPVerificationCodeRepository->findByMobileAndCode($sendOtpRequest->phone, $sendOtpRequest->phone_code);

        if (!$otp) {
            $response['statusCode'] = 422;
            $response['message'] = __('Mobile not found');
            return $response;
        }

        //update expired at
        $this->OTPVerificationCodeRepository->updateExpiredAtFromOTPObject($otp);

        //sendOTP
        //we will execute this code after response as a background job
        SendOtpJob::dispatch($otp->phone, $otp->phone_code, $otp->verification_code)->afterResponse();

        $response['message'] = __('OTP is successfully sent');

        return $response;
    }


    public function signInWithOTP(SigninWithOtpRequest $signinWithOtpRequest)
    {
        $response['data'] = [];
        $response['statusCode'] = 200;
        $response['message'] = null;
        $response['errors'] = [];

        //get otp if exists
        $otp = $this->OTPVerificationCodeRepository->findByMobileAndCode($signinWithOtpRequest->phone, $signinWithOtpRequest->phone_code);

        //if invalid otp
        if (!$otp || ($otp->verification_code != $signinWithOtpRequest->otp)) {
            $response['statusCode'] = 422;
            $response['message'] = __('Invalid OTP');
            return $response;
        }

        //if otp expired
        if ($otp->isExpired()) {
            $response['statusCode'] = 422;
            $response['message'] = __('Please re-send the verification code to try again');
            return $response;
        }

        //remove otp
        $this->OTPVerificationCodeRepository->remove($otp->_id);

        //get user
        $me = $this->userRepository->findByMobile($signinWithOtpRequest->phone, $signinWithOtpRequest->phone_code);

        //create new user if not exists
        if (!$me) {
            $me = $this->userRepository->createUserFromSignin($signinWithOtpRequest->phone, $signinWithOtpRequest->phone_code);
        }

        //if user blocked
        if ($me->isNotActive()) {
            $response['statusCode'] = 422;
            $response['message'] = __('Your account has been locked. Contact your support person to unlock it, then try again.');
            return $response;
        }

        $me->last_login = now();
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
