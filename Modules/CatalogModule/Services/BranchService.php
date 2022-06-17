<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services;

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
        $regionId = @$this->getRegion($createBranchRequest->lat, $createBranchRequest->lng)['id'];

        $branch = $this->branchRepository->create([
            'vendor_id'                 => new ObjectId(getVendorId()),
            'name'                      => $createBranchRequest->name,
            'address'                   => $createBranchRequest->address,
            'lat'                       => $createBranchRequest->lat,
            'lng'                       => $createBranchRequest->lng,
            'cover_images'              => $this->uploadImages('branches', $createBranchRequest->cover_images),
            'is_active'                 => ($createBranchRequest->is_active === null) || (boolean)$createBranchRequest->is_active,
            'phone'                     => ['phone' => $createBranchRequest->phone['phone'], 'phone_code' => $createBranchRequest->phone['phone_code']],
            'region_id'                 => $regionId ? new ObjectId($regionId) : null,
            'city_id'                   => new ObjectId($createBranchRequest->city_id)
        ]);

        return [
            'id'        => $branch->_id
        ];
    }


    public function updateByVendor($branchId, UpdateBranchRequest $updateBranchRequest)
    {
        $vendorId = new ObjectId(getVendorId());

        $branch = $this->branchRepository->find($branchId, ['vendor_id' => $vendorId]);

        $branchCoverImages  = array_merge($branch->cover_images ?? [], $this->uploadImages('branches', $updateBranchRequest->cover_images));;

        $regionId = @$this->getRegion($updateBranchRequest->lat, $updateBranchRequest->lng)['id'];

        $branch = $this->branchRepository->update(new ObjectId($branchId), [
            'name'                          => $updateBranchRequest->name,
            'address'                       => $updateBranchRequest->address,
            'lat'                           => $updateBranchRequest->lat,
            'lng'                           => $updateBranchRequest->lng,
            'cover_images'                  => $branchCoverImages,
            'is_active'                     => ($updateBranchRequest->is_active === null) || (boolean)$updateBranchRequest->is_active,
            'phone'                         => ['phone' => $updateBranchRequest->phone['phone'], 'phone_code' => $updateBranchRequest->phone['phone_code']],
            'region_id'                     => $regionId ? new ObjectId($regionId) : null,
            'city_id'                       => new ObjectId($updateBranchRequest->city_id)
        ], ['vendor_id' => $vendorId]);

        return [
            'id'        => $branch->_id
        ];
    }


    public function destroyByVendor($branchId)
    {
        $vendorId = new ObjectId(getVendorId());

        return $this->branchRepository->destroy($branchId, ['vendor_id' => $vendorId]);
    }


    public function removeImage($id, $imageIndex)
    {
        $vendorId = new ObjectId(getVendorId());

        $branch = $this->branchRepository->find($id, ['vendor_id' => $vendorId]);

        $images = $branch->cover_images;

        if (empty($images)) {
            return null;
        }

        unset($images[$imageIndex]);

        $branch->update(['cover_images' => $images]);

        return $branch;
    }


    private function getRegion($lat, $lng)
    {
        $locationProxy = new CatalogProxy('GET_REGION', ['lat' => $lat, 'lng' => $lng]);
        $proxy = new Proxy($locationProxy);
        return $proxy->result();
    }
}
