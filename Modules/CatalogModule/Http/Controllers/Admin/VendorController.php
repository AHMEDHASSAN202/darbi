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

        return $this->apiResponse(...$result);
    }

    public function update($id, UpdateVendorRequest $updateVendorRequest)
    {
        $result = $this->vendorService->update($id, $updateVendorRequest);

        return $this->apiResponse(...$result);
    }

    public function destroy($id)
    {
        $result = $this->vendorService->destroy($id);

        return $this->apiResponse(...$result);
    }

    public function toggleActive($vendorId)
    {
        $result = $this->vendorService->toggleActive($vendorId);

        return $this->apiResponse(...$result);
    }

    public function authAsVendor(Request $request)
    {
        $result = $this->vendorService->loginAsVendor($request);

        return $this->apiResponse(...$result);
    }
}
