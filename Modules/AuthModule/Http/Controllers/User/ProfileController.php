<?php

namespace Modules\AuthModule\Http\Controllers\User;

use Illuminate\Routing\Controller;
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
        $result = $this->userProfileService->getProfile();

        return $this->apiResponse(...$result);
    }


    public function updateProfile(UpdateProfileRequest $updateProfileRequest)
    {
        $result = $this->userProfileService->updateProfile($updateProfileRequest);

        return $this->apiResponse(...$result);
    }


    public function updateIdentityProfile(UploadIdentityImageRequest $uploadIdentityImageRequest, $type)
    {
        $result = $this->userProfileService->updateIdentityProfile($uploadIdentityImageRequest, $type);

        return $this->apiResponse(...$result);
    }


    public function deleteIdentityProfile($type)
    {
        $result = $this->userProfileService->removeIdentityProfile($type);

        return $this->apiResponse(...$result);
    }


    public function deleteAccount()
    {
        $result = $this->userProfileService->deleteAccount();

        return $this->apiResponse(...$result);
    }
}
