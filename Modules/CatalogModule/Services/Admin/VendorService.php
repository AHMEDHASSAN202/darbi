<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services\Admin;

use Illuminate\Http\Request;
use Modules\AuthModule\Http\Requests\Admin\CreateUserRequest;
use Modules\AuthModule\Http\Requests\Admin\UpdateUserRequest;
use Modules\CatalogModule\Http\Requests\Admin\CreateVendorRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateVendorRequest;
use Modules\CatalogModule\Repositories\VendorRepository;
use Modules\CatalogModule\Services\UserResource;
use Modules\CatalogModule\Transformers\FindVendorResource;
use Modules\CommonModule\Traits\ImageHelperTrait;
use Modules\CommonModule\Transformers\PaginateResource;

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
        $vendors = $this->vendorRepository->listOfVendors($request->get('limit', 20), $request);

        return new PaginateResource(UserResource::collection($vendors));
    }

    public function find($vendorId)
    {
        $vendor = $this->vendorRepository->findOne($vendorId);

        return new FindVendorResource($vendor);
    }

    public function create(CreateVendorRequest $createVendorRequest)
    {
        $data = [];

        $vendor = $this->vendorRepository->create($data);

        return [
            'id'        => $vendor->id
        ];
    }

    public function update($id, UpdateVendorRequest $updateVendorRequest)
    {
        $data = [];

        $vendor = $this->vendorRepository->update($id, $data);

        return [
            'id'        => $vendor->id
        ];
    }

    public function destroy($id)
    {
        return $this->vendorRepository->destroy($id);
    }
}
