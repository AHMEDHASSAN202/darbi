<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services;

use Illuminate\Http\Request;
use Modules\CommonModule\Traits\ImageHelperTrait;
use Modules\CommonModule\Transformers\PaginateResource;
use Modules\VendorModule\Http\Requests\CreateUserRequest;
use Modules\VendorModule\Http\Requests\UpdateUserRequest;
use Modules\VendorModule\Repositories\UserRepository;
use Modules\VendorModule\Transformers\UserResource;

class VendorService
{
    use ImageHelperTrait;

    private $vendorRepository;

    public function __construct(UserRepository $vendorRepository)
    {
        $this->vendorRepository = $vendorRepository;
    }

    public function list(Request $request)
    {
        $vendors = $this->vendorRepository->listOfVendors($request->get('limit', 20), $request);

        return new PaginateResource(UserResource::collection($vendors));
    }

    public function create(CreateUserRequest $createVendorRequest)
    {
        $data = $createVendorRequest->validated();

        if ($createVendorRequest->hasFile('image')) {
            $data['image'] = $this->uploadAvatar($createVendorRequest->file('image'));
        }

        return $this->vendorRepository->create($data);
    }

    public function update($id, UpdateUserRequest $updateVendorRequest)
    {
        $data = $updateVendorRequest->validated();

        if ($updateVendorRequest->hasFile('image')) {
            $data['image'] = $this->uploadAvatar($updateVendorRequest->file('image'));
        }

        return $this->vendorRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->vendorRepository->destroy($id);
    }
}
