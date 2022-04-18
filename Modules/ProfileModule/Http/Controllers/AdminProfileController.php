<?php

namespace Modules\ProfileModule\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CommonModule\Traits\ApiResponseTrait;
use Modules\ProfileModule\Http\Requests\UpdateAdminProfile;
use Modules\ProfileModule\Services\AdminProfileService;

/**
 * @gorup Admin Profile
 *
 * Management Admin Profile
 */
class AdminProfileController extends Controller
{
    use ApiResponseTrait;

    private $adminProfileService;

    public function __construct(AdminProfileService $adminProfileService)
    {
        $this->adminProfileService = $adminProfileService;
    }

    /**
     * Admin Profile
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfile()
    {
        $profile = $this->adminProfileService->getProfile();

        return $this->apiResponse(compact('profile'));
    }

    /**
     * Update Admin Profile
     *
     * @bodyParam name string required
     * @bodyParam email string required
     * @bodyParam password string required
     * @param UpdateAdminProfile $updateAdminProfile
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(UpdateAdminProfile $updateAdminProfile)
    {
        $profile = $this->adminProfileService->updateProfile($updateAdminProfile);

        return $this->apiResponse(compact('profile'), 200, __('Data has been updated successfully'));
    }
}
