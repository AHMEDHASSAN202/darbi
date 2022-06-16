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

        return new BranchResource($branch);
    }


    public function createByVendor(CreateBranchRequest $createBranchRequest)
    {
        $data['vendor_id'] = new ObjectId(getVendorId());
        $data['name']      = $createBranchRequest->name;
        $data['address']   = $createBranchRequest->address;
        $data['lat']   = $createBranchRequest->lat;
        $data['lng']   = $createBranchRequest->lng;
        $data['cover_images'] = $this->uploadImages('branches', $createBranchRequest->cover_images);
        $data['is_active']  = ($createBranchRequest->is_active === null) || (boolean)$createBranchRequest->is_active;
        $data['phone']      = ['phone' => $createBranchRequest->phone, 'phone_code' => $createBranchRequest->phone_code];
        $data['region_id']  = @$this->getRegion($createBranchRequest->lat, $createBranchRequest->lng)['id'];
        $data['city_id']    = $createBranchRequest->city_id;

        $branch = $this->branchRepository->create($data);

        return [
            'id'        => $branch->_id
        ];
    }


    public function updateByVendor($branchId, UpdateBranchRequest $updateBranchRequest)
    {
        $vendorId = new ObjectId(getVendorId());
        $branch = $this->branchRepository->findByVendor($vendorId, new ObjectId($branchId));
        $branchCoverImages  = $branch->cover_images ?? [];
        $branch->name       = $updateBranchRequest->name;
        $branch->address    = $updateBranchRequest->address;
        $branch->lat        = $updateBranchRequest->lat;
        $branch->lng        = $updateBranchRequest->lng;
        $branch->cover_images = $branchCoverImages + $this->uploadImages('branches', $updateBranchRequest->cover_images);
        $branch->is_active  = ($updateBranchRequest->is_active === null) || (boolean)$updateBranchRequest->is_active;
        $branch->phone      = ['phone' => $updateBranchRequest->phone, 'phone_code' => $updateBranchRequest->phone_code];
        $branch->region_id  = @$this->getRegion($updateBranchRequest->lat, $updateBranchRequest->lng)['id'];
        $branch->city_id    = new ObjectId($updateBranchRequest->city_id);
        $branch->save();

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
