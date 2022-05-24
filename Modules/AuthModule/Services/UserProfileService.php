<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Services;

use Modules\AuthModule\Events\UserUpdateMailEvent;
use Modules\AuthModule\Http\Requests\User\UpdateProfilePhoneRequest;
use Modules\AuthModule\Http\Requests\User\UpdateProfileRequest;
use Modules\AuthModule\Jobs\SendOtpJob;
use Modules\AuthModule\Repositories\User\UserRepository;
use Modules\AuthModule\Transformers\UserProfileResource;
use Modules\CommonModule\Traits\ImageHelperTrait;

class UserProfileService
{
    use ImageHelperTrait;

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function getProfile()
    {
        return new UserProfileResource(auth('api')->user());
    }


    public function updateProfile(UpdateProfileRequest $updateProfileRequest)
    {
        $me = auth('api')->user();
        $me->name = $updateProfileRequest->name;

        $redirectTo = 'NEXT';

        if ($updateProfileRequest->email) {
            $me->email = $updateProfileRequest->email;
        }

        if ($updateProfileRequest->hasFile('identity_frontside_image')) {
            $me->identity->frontside_image = $this->uploadImage('identities', $updateProfileRequest->identity_frontside_image);
        }

        if ($updateProfileRequest->hasFile('identity_backside_image')) {
            $me->identity->backside_image = $this->uploadImage('identities', $updateProfileRequest->identity_backside_image);
        }

        if ($updateProfileRequest->phone && ($updateProfileRequest->phone != $me->phone)) {
            $me->pending_phone = $updateProfileRequest->phone;
            $me->verification_code = generateOTPCode();
            $redirectTo = 'OTP_SCREEN';
        }

        //save data
        $me->save();

        if ($me->wasChanged('email')) {
            //send verification code here
            event(new UserUpdateMailEvent($me));
        }

        if ($me->wasChanged('pending_phone')) {
            //send otp to new updated phone
            SendOtpJob::dispatch($updateProfileRequest->phone, $me->phone_code, $me->verification_code)->afterResponse();
        }

        return [
            'message'   => __('Your account has been updated'),
            'statusCode'=>  200,
            'data'      => ['redirectTo' => $redirectTo]
        ];
    }


    public function updatePhone(UpdateProfilePhoneRequest $updateProfilePhoneRequest)
    {
        $response['data'] = [];
        $response['statusCode'] = 200;
        $response['message'] = null;
        $response['errors'] = [];

        //get country
        $country = $this->countryRepository->find($updateProfilePhoneRequest->country_id);
        $phoneCode = $country->calling_code;

        //get user if exists
        $me = $this->userRepository->findByMobile($updateProfilePhoneRequest->phone, $phoneCode);

        //if invalid otp
        if ($me->verification_code != $updateProfilePhoneRequest->otp) {
            $response['statusCode'] = 422;
            $response['message'] = __('Invalid OTP');
            return $response;
        }

        $me->phone = $me->pending_phone;
        $me->verification_code = null;
        $me->pending_phone = null;
        $me->save();

        $response['statusCode'] = 200;
        $response['message'] = __('Your mobile number has been updated');

        return $response;
    }
}
