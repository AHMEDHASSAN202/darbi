<?php

namespace Modules\CatalogModule\Http\Controllers\Admin\Vendor;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Http\Requests\Admin\CreateBranchRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateBranchRequest;
use Modules\CatalogModule\Services\Admin\BranchService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class BranchController extends Controller
{
    use ApiResponseTrait;

    private $branchService;


    public function __construct(BranchService $branchService)
    {
        $this->branchService = $branchService;
    }

    public function index(Request $request)
    {
        $branches = $this->branchService->findAllByVendor($request);

        return $this->apiResponse(compact('branches'));
    }

    public function show($branchId)
    {
        $branch = $this->branchService->findByVendor($branchId);

        return $this->apiResponse(compact('branch'));
    }

    public function store(CreateBranchRequest $createBranchRequest)
    {
        $result = $this->branchService->createByVendor($createBranchRequest);

        return $this->apiResponse(...$result);
    }

    public function update($branchId, UpdateBranchRequest $updateBranchRequest)
    {
        $result = $this->branchService->updateByVendor($branchId, $updateBranchRequest);

        return $this->apiResponse(...$result);
    }

    public function destroy($branchId)
    {
        $result = $this->branchService->destroyByVendor($branchId);

        return $this->apiResponse(...$result);
    }

    public function deleteImage($id, $imageIndex)
    {
        $result = $this->branchService->removeImage($id, $imageIndex);

        return $this->apiResponse(...$result);
    }
}
