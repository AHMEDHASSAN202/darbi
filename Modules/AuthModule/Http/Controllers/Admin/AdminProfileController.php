<?php

namespace Modules\AuthModule\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\AuthModule\Http\Requests\Admin\UpdateAdminProfile;
use Modules\AuthModule\Services\AdminProfileService;
use Modules\CommonModule\Traits\ApiResponseTrait;

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
