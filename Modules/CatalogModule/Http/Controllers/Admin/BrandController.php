<?php

namespace Modules\CatalogModule\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Http\Requests\Admin\CreateBrandRequest;
use Modules\CatalogModule\Http\Requests\Admin\CreatePortRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateBrandRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdatePortRequest;
use Modules\CatalogModule\Services\Admin\BrandService;
use Modules\CatalogModule\Services\Admin\PortService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class BrandController extends Controller
{
    use ApiResponseTrait;

    private $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    public function index(Request $request)
    {
        $brands = $this->brandService->findAllForDashboard($request, false);

        return $this->apiResponse(compact('brands'));
    }

    public function show($brandId)
    {
        return $this->apiResponse([
            'brand'      => $this->brandService->find($brandId)
        ]);
    }

    public function store(CreateBrandRequest $createBrandRequest)
    {
        $result = $this->brandService->create($createBrandRequest);

        return $this->apiResponse($result, 201, __('Data has been added successfully'));
    }

    public function update($id, UpdateBrandRequest $updateBrandRequest)
    {
        $result = $this->brandService->update($id, $updateBrandRequest);

        return $this->apiResponse($result, 200, __('Data has been updated successfully'));
    }

    public function destroy($id)
    {
        $this->brandService->delete($id);

        return $this->apiResponse([], 200, __('Data has been deleted successfully'));
    }
}
