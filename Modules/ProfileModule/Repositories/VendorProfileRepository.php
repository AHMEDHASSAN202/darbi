<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\ProfileModule\Repositories;


use Illuminate\Support\Facades\Hash;
use Modules\CommonModule\Traits\ImageHelperTrait;
use Modules\ProfileModule\Http\Requests\UpdateInfoVendorProfile;
use Modules\ProfileModule\Http\Requests\UpdateVendorProfile;
use Modules\VendorModule\Entities\Vendor;

class VendorProfileRepository
{
    use ImageHelperTrait;

    private $model;

    private $guardName = 'vendor_api';

    public function __construct(Vendor $model)
    {
        $this->model = $model;
    }

    public function updateProfile(UpdateVendorProfile $updateVendorProfile)
    {
        $me = auth($this->guardName)->user();
        $me->name = $updateVendorProfile->name;
        $me->email = $updateVendorProfile->email;
        $me->password = Hash::make($updateVendorProfile->password);
        $me->save();
        return $me;
    }

    public function updateInfo(UpdateInfoVendorProfile $updateInfoVendorProfile)
    {
        $me = auth($this->guardName)->user();
        $me->country = $updateInfoVendorProfile->country;
        $me->city = $updateInfoVendorProfile->city;
        $me->phone = $updateInfoVendorProfile->phone;
        if ($updateInfoVendorProfile->hasFile('image')) {
            $me->image = $this->uploadAvatar($updateInfoVendorProfile->image);
        }
        $me->save();
        return $me;
    }
}
