<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\ProfileModule\Services;

use Modules\ProfileModule\Http\Requests\UpdateInfoVendorProfile;
use Modules\ProfileModule\Repositories\VendorProfileRepository;
use Modules\ProfileModule\Transformers\VendorProfileResource;

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

        return (new VendorProfileResource($me));
    }

    public function updateProfile($request)
    {
        $me = $this->vendorProfileRepository->updateProfile($request);

        return (new VendorProfileResource($me));
    }

    public function updateInfo(UpdateInfoVendorProfile $updateInfoVendorProfile)
    {
        $me = $this->vendorProfileRepository->updateInfo($updateInfoVendorProfile);

        return (new VendorProfileResource($me));
    }
}
