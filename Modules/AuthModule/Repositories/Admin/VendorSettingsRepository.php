<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Repositories\Admin;


use Modules\AuthModule\Http\Requests\Admin\UpdateInfoVendorProfile;
use Modules\AuthModule\Http\Requests\Admin\UpdateVendorSettingsRequest;
use Modules\CatalogModule\Entities\Vendor;
use Modules\CommonModule\Traits\ImageHelperTrait;

class VendorSettingsRepository
{
    use ImageHelperTrait;

    private $model;

    public function __construct(Vendor $model)
    {
        $this->model = $model;
    }

    public function updateVendorInfo(UpdateVendorSettingsRequest $updateVendorInfoRequest)
    {
        $vendor = auth('vendor_api')->user()->vendor;
        $vendor->name = $updateVendorInfoRequest->name;
        $vendor->email = $updateVendorInfoRequest->email;
        $vendor->phone = $updateVendorInfoRequest->phone;
        if ($updateVendorInfoRequest->hasFile('image')) {
            $vendor->image = $this->uploadImage('vendors', $updateVendorInfoRequest->image);
        }
        $vendor->settings = $updateVendorInfoRequest->settings ?? [];
        $vendor->country_currency_code = $updateVendorInfoRequest->currency_code;
        $vendor->save();
        return $vendor;
    }
}
