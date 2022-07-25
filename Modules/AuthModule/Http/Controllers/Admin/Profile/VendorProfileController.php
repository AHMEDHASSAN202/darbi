<?php

namespace Modules\AuthModule\Http\Controllers\Admin\Profile;

use Illuminate\Routing\Controller;
use Modules\AuthModule\Http\Requests\Admin\UpdateInfoVendorProfile;
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
        $result = $this->vendorProfileService->getProfile();

        return $this->apiResponse(...$result);
    }


    public function updateProfile(UpdateVendorProfileRequest $updateVendorProfile)
    {
        $result = $this->vendorProfileService->updateProfile($updateVendorProfile);

        return $this->apiResponse(...$result);
    }
}
