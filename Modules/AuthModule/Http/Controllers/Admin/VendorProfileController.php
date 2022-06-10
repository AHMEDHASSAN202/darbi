<?php

namespace Modules\AuthModule\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\AuthModule\Http\Requests\Admin\UpdateInfoVendorProfile;
use Modules\AuthModule\Http\Requests\Admin\UpdateVendorProfile;
use Modules\AuthModule\Services\VendorProfileService;
use Modules\CommonModule\Traits\ApiResponseTrait;
use function __;


class VendorProfileController extends Controller
{
    use ApiResponseTrait;

    private $vendorProfileService;

    public function __construct(VendorProfileService $vendorProfileService)
    {
        $this->vendorProfileService = $vendorProfileService;
    }

    /**
     * Vendor Profile
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfile()
    {
        $profile = $this->vendorProfileService->getProfile();

        return $this->apiResponse(compact('profile'));
    }

    /**
     * Update Vendor Profile
     *
     * @bodyParam name string required
     * @bodyParam email string required
     * @bodyParam password string required
     * @param UpdateVendorProfile $updateVendorProfile
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(UpdateVendorProfile $updateVendorProfile)
    {
        $profile = $this->vendorProfileService->updateProfile($updateVendorProfile);

        return $this->apiResponse(compact('profile'), 200, __('Data has been updated successfully'));
    }
}
