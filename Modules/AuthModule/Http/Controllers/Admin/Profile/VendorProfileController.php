<?php

namespace Modules\AuthModule\Http\Controllers\Admin\Profile;

use Illuminate\Routing\Controller;
use Modules\AuthModule\Http\Requests\Admin\UpdateInfoVendorProfile;
use Modules\AuthModule\Http\Requests\Admin\UpdateVendorInfoRequest;
use Modules\AuthModule\Http\Requests\Admin\UpdateVendorProfileRequest;
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


    public function getProfile()
    {
        $profile = $this->vendorProfileService->getProfile();

        return $this->apiResponse(compact('profile'));
    }


    public function updateProfile(UpdateVendorProfileRequest $updateVendorProfile)
    {
        $profile = $this->vendorProfileService->updateProfile($updateVendorProfile);

        return $this->apiResponse(compact('profile'), 200, __('Data has been updated successfully'));
    }


    public function getVendor()
    {
        $vendor = $this->vendorProfileService->getVendor();

        return $this->apiResponse(compact('vendor'));
    }


    public function updateVendor(UpdateVendorInfoRequest $updateVendorInfoRequest)
    {
        $vendor = $this->vendorProfileService->updateVendorInfo($updateVendorInfoRequest);

        return $this->apiResponse(compact('vendor'), 200, __('Data has been updated successfully'));
    }
}
