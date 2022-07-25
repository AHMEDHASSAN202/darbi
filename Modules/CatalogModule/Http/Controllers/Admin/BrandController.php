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
        $result = $this->brandService->findAllForDashboard($request, false);

        return $this->apiResponse(...$result);
    }

    public function show($brandId)
    {
        $result = $this->brandService->find($brandId);

        return $this->apiResponse(...$result);
    }

    public function store(CreateBrandRequest $createBrandRequest)
    {
        $result = $this->brandService->create($createBrandRequest);

        return $this->apiResponse(...$result);
    }

    public function update($id, UpdateBrandRequest $updateBrandRequest)
    {
        $result = $this->brandService->update($id, $updateBrandRequest);

        return $this->apiResponse(...$result);
    }

    public function destroy($id)
    {
        $result = $this->brandService->delete($id);

        return $this->apiResponse(...$result);
    }
}
