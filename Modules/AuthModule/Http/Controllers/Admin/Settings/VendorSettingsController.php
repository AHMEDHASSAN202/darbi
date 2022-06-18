<?php

namespace Modules\AuthModule\Http\Controllers\Admin\Profile;

use Illuminate\Routing\Controller;
use Modules\AuthModule\Http\Requests\Admin\UpdateInfoVendorProfile;
use Modules\AuthModule\Http\Requests\Admin\UpdateVendorSettingsRequest;
use Modules\AuthModule\Services\VendorSettingsService;
use Modules\CommonModule\Traits\ApiResponseTrait;


class VendorSettingsController extends Controller
{
    use ApiResponseTrait;

    private $vendorSettingsService;

    public function __construct(VendorSettingsService $vendorSettingsService)
    {
        $this->vendorSettingsService = $vendorSettingsService;
    }

    public function getSettings()
    {
        $vendor = $this->vendorSettingsService->getSettings();

        return $this->apiResponse(compact('vendor'));
    }


    public function updateSettings(UpdateVendorSettingsRequest $updateVendorInfoRequest)
    {
        $vendor = $this->vendorSettingsService->updateSettings($updateVendorInfoRequest);

        return $this->apiResponse(compact('vendor'), 200, __('Data has been updated successfully'));
    }
}
