<?php

namespace Modules\ProfileModule\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CommonModule\Traits\ApiResponseTrait;
use Modules\ProfileModule\Http\Requests\UpdateInfoVendorProfile;
use Modules\ProfileModule\Http\Requests\UpdateVendorProfile;
use Modules\ProfileModule\Services\VendorProfileService;

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

    /**
     * Update Vendor Profile Info
     *
     * @bodyParam phone string required
     * @bodyParam country string required
     * @bodyParam city string required
     * @bodyParam image file optional
     * @param UpdateVendorProfile $updateVendorProfile
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateInfo(UpdateInfoVendorProfile $updateInfoVendorProfile)
    {
        $profile = $this->vendorProfileService->updateInfo($updateInfoVendorProfile);

        return $this->apiResponse(compact('profile'), 200, __('Data has been updated successfully'));
    }
}
