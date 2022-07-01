<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services\Admin;

use App\Proxy\Proxy;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\AuthModule\Entities\Admin;
use Modules\CatalogModule\Entities\Vendor;
use Modules\CatalogModule\Http\Requests\Admin\CreateVendorRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateVendorRequest;
use Modules\CatalogModule\Proxy\CatalogProxy;
use Modules\CatalogModule\Repositories\VendorRepository;
use Modules\CatalogModule\Services\UserResource;
use Modules\CatalogModule\Transformers\Admin\FindVendorResource;
use Modules\CatalogModule\Transformers\Admin\VendorResource;
use Modules\CommonModule\Traits\ImageHelperTrait;
use Modules\CommonModule\Transformers\PaginateResource;
use MongoDB\BSON\ObjectId;

class VendorService
{
    use ImageHelperTrait;

    private $vendorRepository;

    public function __construct(VendorRepository $vendorRepository)
    {
        $this->vendorRepository = $vendorRepository;
    }

    public function findAll(Request $request)
    {
        $vendors = $this->vendorRepository->listOfVendors($request);

        if ($vendors instanceof LengthAwarePaginator) {
            return new PaginateResource(VendorResource::collection($vendors));
        }

        return VendorResource::collection($vendors);
    }

    public function find($vendorId)
    {
        $vendor = $this->vendorRepository->findOne($vendorId);

        return new FindVendorResource($vendor);
    }

    public function create(CreateVendorRequest $createVendorRequest)
    {
        $vendor = $this->vendorRepository->create([
            'name'          => $createVendorRequest->name,
            'image'         => $this->uploadImage('vendors', $createVendorRequest->image),
            'phone'         => $createVendorRequest->phone,
            'phone_code'    => $createVendorRequest->phone_code,
            'is_active'     => ($createVendorRequest->is_active === null) || (boolean)$createVendorRequest->is_active,
            'country_id'    => new ObjectId($createVendorRequest->country_id),
            'email'         => $createVendorRequest->email,
            'darbi_percentage'  => $createVendorRequest->darbi_percentage ? (int)$createVendorRequest->darbi_percentage : null,
            'settings'      => $createVendorRequest->settings,
            'type'          => $createVendorRequest->type,
            'created_by'    => new ObjectId(auth('admin_api')->id())
        ]);


        //get vendor admin role
        $roleProxy =  new CatalogProxy('GET_VENDOR_ROLE');
        $role = (new Proxy($roleProxy))->result();

        //create vendor admin
        $vendorAdminProxy = new CatalogProxy('CREATE_VENDOR_ADMIN', [
            'name'          => $createVendorRequest->name['en'],
            'email'         => $createVendorRequest->email,
            'password'      => $createVendorRequest->password,
            'password_confirmation' => $createVendorRequest->password,
            'role_id'       => $role['id'],
            'type'          => 'vendor',
            'vendor_id'     => (string)$vendor->id
        ]);

        $proxy = new Proxy($vendorAdminProxy);
        $vendorAdminProxy = $proxy->result();

        return [
            'id'        => $vendor->id
        ];
    }

    public function update($id, UpdateVendorRequest $updateVendorRequest)
    {
        $data = [
            'name'          => $updateVendorRequest->name,
            'phone'         => $updateVendorRequest->phone,
            'phone_code'    => $updateVendorRequest->phone_code,
            'is_active'     => ($updateVendorRequest->is_active === null) || (boolean)$updateVendorRequest->is_active,
            'email'         => $updateVendorRequest->email,
            'darbi_percentage'  => $updateVendorRequest->darbi_percentage ? (int)$updateVendorRequest->darbi_percentage : null,
            'settings'      => $updateVendorRequest->settings
        ];

        if ($updateVendorRequest->image) {
            $data['image'] = $this->uploadImage('vendors', $updateVendorRequest->image);
        }

        $vendor = $this->vendorRepository->update($id, $data);

        return [
            'id'        => $vendor->id
        ];
    }

    public function destroy($id)
    {
        return $this->vendorRepository->destroy($id);
    }

    public function toggleActive($vendorId)
    {
        $this->vendorRepository->toggleActive($vendorId);

        return [
            'id'    => $vendorId
        ];
    }

    public function loginAsVendor(Request $request)
    {
        $admin = Admin::where('vendor_id', new ObjectId($request->vendor_id))->firstOrFail();

        return auth('vendor_api')->login($admin);
    }
}
