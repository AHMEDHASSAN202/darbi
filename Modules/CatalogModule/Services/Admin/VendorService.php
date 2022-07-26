<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services\Admin;

use App\Proxy\Proxy;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CatalogModule\Http\Requests\Admin\CreateVendorRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateVendorRequest;
use Modules\CatalogModule\Proxy\CatalogProxy;
use Modules\CatalogModule\Repositories\VendorRepository;
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
        $role = $this->getVendorRole();

        if (!$role || !$role['id']) {
            return badResponse([], __('Default vendor role not exists.'));
        }

        $country = $this->getCountry($createVendorRequest->country_id);

        if (!$country) {
            return badResponse([], __('country not exists.'));
        }

        $vendor = $this->vendorRepository->create([
            'name'          => $createVendorRequest->name,
            'image'         => $this->uploadImage('vendors', $createVendorRequest->image),
            'phone'         => $createVendorRequest->phone,
            'phone_code'    => $createVendorRequest->phone_code,
            'is_active'     => ($createVendorRequest->is_active === null) || (boolean)$createVendorRequest->is_active,
            'country_id'    => new ObjectId($createVendorRequest->country_id),
            'country_currency_code' => arrayGet($country, 'currency_code'),
            'email'         => $createVendorRequest->email,
            'darbi_percentage'  => $createVendorRequest->darbi_percentage ? (int)$createVendorRequest->darbi_percentage : null,
            'settings'      => $createVendorRequest->settings,
            'type'          => $createVendorRequest->type,
            'created_by'    => new ObjectId(auth('admin_api')->id()),
            'lat'           => (float)$createVendorRequest->lat,
            'lng'           => (float)$createVendorRequest->lng
        ]);

        $admin = $this->createVendorAdmin([
            'name'          => $createVendorRequest->name['en'],
            'email'         => $createVendorRequest->email,
            'password'      => $createVendorRequest->password,
            'password_confirmation' => $createVendorRequest->password,
            'role_id'       => $role['id'],
            'type'          => 'vendor',
            'vendor_id'     => (string)$vendor->id
        ]);

        if (!$admin || !$admin['id']) {
            return createdResponse([], __('Vendor admin cannot be created, please create it manually'));
        }

        return createdResponse(['id' => $vendor->id]);
    }


    private function getVendorRole()
    {
        //get vendor admin role
        $roleProxy =  new CatalogProxy('GET_VENDOR_ROLE');

        return (new Proxy($roleProxy))->result();
    }


    private function createVendorAdmin($data)
    {
        //create vendor admin
        $vendorAdminProxy = new CatalogProxy('CREATE_VENDOR_ADMIN', $data);

        $proxy = new Proxy($vendorAdminProxy);

        return $proxy->result();
    }


    public function update($id, UpdateVendorRequest $updateVendorRequest)
    {
        $vendor = $this->vendorRepository->find($id);

        $data = [
            'name'          => $updateVendorRequest->name,
            'phone'         => $updateVendorRequest->phone,
            'phone_code'    => $updateVendorRequest->phone_code,
            'is_active'     => ($updateVendorRequest->is_active === null) || (boolean)$updateVendorRequest->is_active,
            'email'         => $updateVendorRequest->email,
            'darbi_percentage'  => $updateVendorRequest->darbi_percentage ? (int)$updateVendorRequest->darbi_percentage : null,
            'settings'      => $updateVendorRequest->settings,
            'lat'           => (float)$updateVendorRequest->lat,
            'lng'           => (float)$updateVendorRequest->lng
        ];

        $oldImage = null;
        if ($updateVendorRequest->image) {
            $oldImage = $vendor->image;
            $data['image'] = $this->uploadImage('vendors', $updateVendorRequest->image);
        }

        $vendor->update($data);

        $this->_removeImage($oldImage);

        return updatedResponse(['id' => $vendor->id]);
    }


    public function destroy($id)
    {
        $this->vendorRepository->destroy($id);

        return deletedResponse();
    }


    public function toggleActive($vendorId)
    {
        $this->vendorRepository->toggleActive($vendorId);

        return updatedResponse(['id' => $vendorId]);
    }


    public function loginAsVendor(Request $request)
    {
        $request->validate(['vendor_id' => 'required']);

        $token = $this->getVendorAdminToken($request->vendor_id);

        if (!$token) {
            return badResponse([], __('Vendor admin not exists, please create it and try again'));
        }

        return successResponse(['token' => $token]);
    }


    public function getVendorAdminToken($vendorId)
    {
        //get vendor admin token
        $catalogProxy =  new CatalogProxy('GET_VENDOR_ADMIN_TOKEN', ['vendor_id' => $vendorId]);

        return @(new Proxy($catalogProxy))->result();
    }

    private function getCountry($countryId)
    {
        $catalogProxy =  new CatalogProxy('GET_COUNTRY', ['country_id' => $countryId]);

        return @(new Proxy($catalogProxy))->result();
    }
}
