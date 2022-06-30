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
        $branch = $this->branchService->createByVendor($createBranchRequest);

        return $this->apiResponse(compact('branch'), 201, __('Data has been added successfully'));
    }

    public function update($branchId, UpdateBranchRequest $updateBranchRequest)
    {
        $branch = $this->branchService->updateByVendor($branchId, $updateBranchRequest);

        return $this->apiResponse(compact('branch'), 200, __('Data has been updated successfully'));
    }

    public function destroy($branchId)
    {
        $this->branchService->destroyByVendor($branchId);

        return $this->apiResponse([], 200, __('Data has been deleted successfully'));
    }

    public function deleteImage($id, $imageIndex)
    {
        $this->branchService->removeImage($id, $imageIndex);

        return $this->apiResponse([], 200, __('Data has been deleted successfully'));
    }
}
