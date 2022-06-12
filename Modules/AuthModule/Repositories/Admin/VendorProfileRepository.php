<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Repositories\Admin;


use Illuminate\Support\Facades\Hash;
use Modules\AuthModule\Http\Requests\Admin\UpdateInfoVendorProfile;
use Modules\AuthModule\Http\Requests\Admin\UpdateVendorInfoRequest;
use Modules\AuthModule\Http\Requests\Admin\UpdateVendorProfile;
use Modules\CatalogModule\Entities\Vendor;
use Modules\CommonModule\Traits\ImageHelperTrait;
use MongoDB\BSON\ObjectId;
use function auth;

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
        if ($updateVendorProfile->hasFile('image')) {
            $me->image = $this->uploadAvatar($updateVendorProfile->image);
        }
        $me->save();
        return $me;
    }

    public function updateInfo(UpdateVendorInfoRequest $updateVendorInfoRequest)
    {
        $vendor = auth($this->guardName)->user()->vendor;
        $vendor->name = $updateVendorInfoRequest->name;
        $vendor->email = $updateVendorInfoRequest->email;
        $vendor->phone = $updateVendorInfoRequest->phone;
        $vendor->country = new ObjectId($updateVendorInfoRequest->country);
        if ($updateVendorInfoRequest->hasFile('image')) {
            $vendor->image = $this->uploadAvatar($updateVendorInfoRequest->image);
        }
        $vendor->save();
        return $vendor;
    }
}
