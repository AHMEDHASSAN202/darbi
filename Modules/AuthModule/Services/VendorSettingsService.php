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
use Modules\AuthModule\Transformers\FindVendorResource;


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

        return updatedResponse(['vendor' => new FindVendorResource($vendor)]);
    }

    public function getSettings()
    {
        $vendor = auth('vendor_api')->user()->vendor->load('country');

        return successResponse(['vendor' => new FindVendorResource($vendor)]);
    }
}
