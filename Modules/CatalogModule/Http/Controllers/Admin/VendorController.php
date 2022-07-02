<?php

namespace Modules\CatalogModule\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Http\Requests\Admin\CreateVendorRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateVendorRequest;
use Modules\CatalogModule\Services\Admin\VendorService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class VendorController extends Controller
{
    use ApiResponseTrait;

    private $vendorService;

    public function __construct(VendorService $vendorService)
    {
        $this->vendorService = $vendorService;
    }

    public function index(Request $request)
    {
        $vendors = $this->vendorService->findAll($request);

        return $this->apiResponse(compact('vendors'));
    }

    public function show($vendorId)
    {
        return $this->apiResponse([
            'vendor'      => $this->vendorService->find($vendorId)
        ]);
    }

    public function store(CreateVendorRequest $createVendorRequest)
    {
        $result = $this->vendorService->create($createVendorRequest);

        return $this->apiResponse($result['data'], $result['statusCode'], $result['message']);
    }

    public function update($id, UpdateVendorRequest $updateVendorRequest)
    {
        $result = $this->vendorService->update($id, $updateVendorRequest);

        return $this->apiResponse($result, 200, __('Data has been updated successfully'));
    }

    public function destroy($id)
    {
        $this->vendorService->destroy($id);

        return $this->apiResponse([], 200, __('Data has been deleted successfully'));
    }

    public function toggleActive($vendorId)
    {
        $result = $this->vendorService->toggleActive($vendorId);

        return $this->apiResponse($result, 200, __('Data has been updated successfully'));
    }

    public function authAsVendor(Request $request)
    {
        $result = $this->vendorService->loginAsVendor($request);

        return $this->apiResponse($result['data'], $result['statusCode'], $result['message']);
    }
}
