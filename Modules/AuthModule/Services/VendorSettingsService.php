<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Services;

use Modules\AuthModule\Http\Requests\Admin\UpdateInfoVendorProfile;
use Modules\AuthModule\Http\Requests\Admin\UpdateVendorSettingsRequest;
use Modules\AuthModule\Repositories\Admin\VendorProfileRepository;
use Modules\AuthModule\Repositories\Admin\VendorSettingsRepository;
use Modules\AuthModule\Transformers\AdminProfileResource;
use Modules\AuthModule\Transformers\VendorDetailsResource;


class VendorSettingsService
{
    private $vendorSettingsRepository;

    public function __construct(VendorSettingsRepository $vendorSettingsRepository)
    {
        $this->vendorSettingsRepository = $vendorSettingsRepository;
    }

    public function updateSettings(UpdateVendorSettingsRequest $updateVendorInfoRequest)
    {
        $vendor = $this->vendorSettingsRepository->updateVendorInfo($updateVendorInfoRequest);

        return new VendorDetailsResource($vendor);
    }

    public function getSettings()
    {
        $vendor = auth($this->guardName)->user()->vendor;

        return new VendorDetailsResource($vendor);
    }
}
