<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Services;

use Modules\AuthModule\Http\Requests\User\UpdateProfilePhoneRequest;
use Modules\AuthModule\Http\Requests\User\UpdateProfileRequest;
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
        $me->note = $updateProfileRequest->note;

        if ($updateProfileRequest->hasFile('identity_frontside_image')) {
            $me->identity->frontside_image = $this->uploadImage('identities', $updateProfileRequest->identity_frontside_image);
        }

        if ($updateProfileRequest->hasFile('identity_backside_image')) {
            $me->identity->backside_image = $this->uploadImage('identities', $updateProfileRequest->identity_backside_image);
        }

        //save data
        $me->save();

        return [
            'message'   => __('Your account has been updated'),
            'statusCode'=>  200,
            'data'      => [
                'profile'       => new UserProfileResource($me)
            ]
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
