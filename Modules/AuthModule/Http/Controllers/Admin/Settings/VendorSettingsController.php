<?php

namespace Modules\AuthModule\Http\Controllers\Admin\Settings;

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
        $result = $this->vendorSettingsService->getSettings();

        return $this->apiResponse(...$result);
    }


    public function updateSettings(UpdateVendorSettingsRequest $updateVendorInfoRequest)
    {
        $result = $this->vendorSettingsService->updateSettings($updateVendorInfoRequest);

        return $this->apiResponse(...$result);
    }
}
