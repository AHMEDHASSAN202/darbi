<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Services;

use Modules\AuthModule\Http\Requests\Admin\UpdateInfoVendorProfile;
use Modules\AuthModule\Repositories\Admin\VendorProfileRepository;
use Modules\AuthModule\Transformers\VendorResource;
use function auth;

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

        return (new VendorResource($me));
    }

    public function updateProfile($request)
    {
        $me = $this->vendorProfileRepository->updateProfile($request);

        return (new VendorResource($me));
    }

    public function updateInfo(UpdateInfoVendorProfile $updateInfoVendorProfile)
    {
        $me = $this->vendorProfileRepository->updateInfo($updateInfoVendorProfile);

        return (new VendorResource($me));
    }
}
