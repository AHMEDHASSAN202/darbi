<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services\Admin;

use App\Proxy\Proxy;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CatalogModule\Http\Requests\Admin\CreateBranchRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateBranchRequest;
use Modules\CatalogModule\Proxy\CatalogProxy;
use Modules\CatalogModule\Repositories\BranchRepository;
use Modules\CatalogModule\Transformers\Admin\BranchResource;
use Modules\CatalogModule\Transformers\Admin\FindBranchResource;
use Modules\CommonModule\Traits\ImageHelperTrait;
use Modules\CommonModule\Transformers\PaginateResource;
use MongoDB\BSON\ObjectId;
use function getVendorId;

class BranchService
{
    use ImageHelperTrait;

    private $branchRepository;


    public function __construct(BranchRepository $branchRepository)
    {
        $this->branchRepository = $branchRepository;
    }

    public function findAllByVendor(Request $request)
    {
        $vendorId = new ObjectId(getVendorId());
        $branches = $this->branchRepository->findAllByVendor($vendorId, $request);

        if ($branches instanceof LengthAwarePaginator) {
            return new PaginateResource(BranchResource::collection($branches));
        }

        return BranchResource::collection($branches);
    }


    public function findByVendor($id)
    {
        $vendorId = new ObjectId(getVendorId());
        $branchId = new ObjectId($id);

        $branch = $this->branchRepository->findByVendor($vendorId, $branchId);

        return new FindBranchResource($branch);
    }


    public function createByVendor(CreateBranchRequest $createBranchRequest)
    {
        $branch = $this->branchRepository->create([
            'vendor_id'                 => new ObjectId(getVendorId()),
            'name'                      => $createBranchRequest->name,
            'address'                   => $createBranchRequest->address,
            'lat'                       => $createBranchRequest->lat,
            'lng'                       => $createBranchRequest->lng,
            'cover_images'              => $this->uploadImages('branches', $createBranchRequest->cover_images),
            'is_active'                 => ($createBranchRequest->is_active === null) || (boolean)$createBranchRequest->is_active,
            'phone'                     => ['phone' => $createBranchRequest->phone, 'phone_code' => $createBranchRequest->phone ? $createBranchRequest->phone_code : null],
            'regions_ids'               => generateObjectIdOfArrayValues($createBranchRequest->region_ids),
            'country_id'                => new ObjectId($createBranchRequest->country_id),
            'city_id'                   => new ObjectId($createBranchRequest->city_id),
            'currency_code'             => $createBranchRequest->currency_code
        ]);

        return createdResponse(['id' => $branch->_id]);
    }


    public function updateByVendor($branchId, UpdateBranchRequest $updateBranchRequest)
    {
        $vendorId = new ObjectId(getVendorId());

        $branch = $this->branchRepository->find($branchId, ['vendor_id' => $vendorId]);

        $branchCoverImages  = array_merge($branch->cover_images ?? [], $this->uploadImages('branches', $updateBranchRequest->cover_images));

        $branch = $this->branchRepository->update(new ObjectId($branchId), [
            'name'                          => $updateBranchRequest->name,
            'address'                       => $updateBranchRequest->address,
            'lat'                           => $updateBranchRequest->lat,
            'lng'                           => $updateBranchRequest->lng,
            'cover_images'                  => $branchCoverImages,
            'is_active'                     => ($updateBranchRequest->is_active === null) || (boolean)$updateBranchRequest->is_active,
            'phone'                         => ['phone' => $updateBranchRequest->phone, 'phone_code' => $updateBranchRequest->phone ? $updateBranchRequest->phone_code : null],
            'regions_ids'                   => generateObjectIdOfArrayValues($updateBranchRequest->region_ids),
            'country_id'                    => new ObjectId($updateBranchRequest->country_id),
            'city_id'                       => new ObjectId($updateBranchRequest->city_id),
            'currency_code'                 => $updateBranchRequest->currency_code
        ], ['vendor_id' => $vendorId]);

        return updatedResponse(['id' => $branch->_id]);
    }


    public function destroyByVendor($branchId)
    {
        $vendorId = new ObjectId(getVendorId());

        $this->branchRepository->destroy($branchId, ['vendor_id' => $vendorId]);

        return deletedResponse();
    }


    public function removeImage($id, $imageIndex)
    {
        $vendorId = new ObjectId(getVendorId());

        $branch = $this->branchRepository->find($id, ['vendor_id' => $vendorId]);

        $images = $branch->cover_images;

        if (empty($images)) {
            return null;
        }

        $image = $images[$imageIndex];

        unset($images[$imageIndex]);

        $branch->update(['cover_images' => array_values($images)]);

        $this->_removeImage($image);

        return deletedResponse($branch);
    }


    public function find($branchId)
    {
        $branch = $this->branchRepository->find($branchId);

        return new BranchResource($branch);
    }
}
