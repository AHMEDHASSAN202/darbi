<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Services;

use Modules\AuthModule\Http\Requests\Admin\UpdateInfoVendorProfile;
use Modules\AuthModule\Http\Requests\Admin\UpdateVendorSettingsRequest;
use Modules\AuthModule\Repositories\Admin\VendorProfileRepository;
use Modules\AuthModule\Transformers\AdminProfileResource;
use Modules\AuthModule\Transformers\FindVendorResource;


class VendorProfileService
{
    private $guardName = 'vendor_api';

    private $vendorProfileRepository;

    public function __construct(VendorProfileRepository $vendorProfileRepository)
    {
        $this->vendorProfileRepository = $vendorProfileRepository;
    }

    public function getProfile()
    {
        $me = auth($this->guardName)->user();

        return successResponse(['profile' => (new AdminProfileResource($me))]);
    }

    public function updateProfile($request)
    {
        $me = $this->vendorProfileRepository->updateProfile($request);

        return updatedResponse(['profile' => (new AdminProfileResource($me))]);
    }

    public function getVendor()
    {
        $vendor = auth($this->guardName)->user()->vendor;

        return new FindVendorResource($vendor);
    }
}
