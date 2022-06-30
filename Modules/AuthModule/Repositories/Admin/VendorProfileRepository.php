<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Repositories\Admin;


use Illuminate\Support\Facades\Hash;
use Modules\AuthModule\Http\Requests\Admin\UpdateInfoVendorProfile;
use Modules\AuthModule\Http\Requests\Admin\UpdateVendorProfileRequest;
use Modules\CatalogModule\Entities\Vendor;
use Modules\CommonModule\Traits\ImageHelperTrait;
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

    public function updateProfile(UpdateVendorProfileRequest $updateVendorProfile)
    {
        $me = auth($this->guardName)->user();
        $me->name = $updateVendorProfile->name;
        $me->email = $updateVendorProfile->email;
        if ($updateVendorProfile->password) {
            $me->password = Hash::make($updateVendorProfile->password);
        }
        if ($updateVendorProfile->hasFile('image')) {
            $me->image = $this->uploadAvatar($updateVendorProfile->image);
        }
        $me->save();
        return $me;
    }
}
