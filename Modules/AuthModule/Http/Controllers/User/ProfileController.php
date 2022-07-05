<?php

namespace Modules\AuthModule\Http\Controllers\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AuthModule\Http\Requests\User\UpdateProfilePhoneRequest;
use Modules\AuthModule\Http\Requests\User\UpdateProfileRequest;
use Modules\AuthModule\Http\Requests\User\UploadIdentityImageRequest;
use Modules\AuthModule\Services\UserProfileService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class ProfileController extends Controller
{
    use ApiResponseTrait;

    private $userProfileService;


    public function __construct(UserProfileService $userProfileService)
    {
        $this->userProfileService = $userProfileService;
    }


    public function getProfile()
    {
        return $this->apiResponse([
            //TODO: bad design because exception is not handled, ypu should make sure that the user is returned then do resp
            'profile'       => $this->userProfileService->getProfile()
        ]);
    }


    public function updateProfile(UpdateProfileRequest $updateProfileRequest)
    {
        $result = $this->userProfileService->updateProfile($updateProfileRequest);

        return $this->apiResponse($result['data'], $result['statusCode'], $result['message']);
    }


    public function updateIdentityProfile(UploadIdentityImageRequest $uploadIdentityImageRequest, $type)
    {
        $result = $this->userProfileService->updateIdentityProfile($uploadIdentityImageRequest, $type);

        return $this->apiResponse($result['data'], $result['statusCode'], $result['message']);
    }


    public function deleteIdentityProfile($type)
    {
        $result = $this->userProfileService->removeIdentityProfile($type);

        return $this->apiResponse($result['data'], $result['statusCode'], $result['message']);
    }
}
