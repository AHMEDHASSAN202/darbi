<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Services;

use Modules\AuthModule\Http\Requests\Admin\UpdateInfoVendorProfile;
use Modules\AuthModule\Http\Requests\Admin\UpdateVendorInfoRequest;
use Modules\AuthModule\Repositories\Admin\VendorProfileRepository;
use Modules\AuthModule\Transformers\AdminProfileResource;
use Modules\AuthModule\Transformers\VendorDetailsResource;


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

        return (new AdminProfileResource($me));
    }

    public function updateProfile($request)
    {
        $me = $this->vendorProfileRepository->updateProfile($request);

        return (new AdminProfileResource($me));
    }

    public function updateVendorInfo(UpdateVendorInfoRequest $updateVendorInfoRequest)
    {
        $vendor = $this->vendorProfileRepository->updateVendorInfo($updateVendorInfoRequest);

        return new VendorDetailsResource($vendor);
    }

    public function getVendor()
    {
        $vendor = auth($this->guardName)->user()->vendor;

        return new VendorDetailsResource($vendor);
    }
}
