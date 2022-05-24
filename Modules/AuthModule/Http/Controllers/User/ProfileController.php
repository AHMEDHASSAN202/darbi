<?php

namespace Modules\AuthModule\Http\Controllers\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AuthModule\Http\Requests\User\UpdateProfilePhoneRequest;
use Modules\AuthModule\Http\Requests\User\UpdateProfileRequest;
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
            'profile'       => $this->userProfileService->getProfile()
        ]);
    }


    public function updateProfile(UpdateProfileRequest $updateProfileRequest)
    {
        $result = $this->userProfileService->updateProfile($updateProfileRequest);

        return $this->apiResponse($result['data'], $result['statusCode'], $result['message']);
    }


    public function updateProfilePhone(UpdateProfilePhoneRequest $updateProfilePhoneRequest)
    {
        $result = $this->userProfileService->updatePhone($updateProfilePhoneRequest);

        return $this->apiResponse($result['data'], $result['statusCode'], $result['message'], $result['errors']);
    }
}
