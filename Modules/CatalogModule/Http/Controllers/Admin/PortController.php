<?php

namespace Modules\CatalogModule\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Http\Requests\Admin\CreatePortRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdatePortRequest;
use Modules\CatalogModule\Services\BrandService;
use Modules\CatalogModule\Services\PluginService;
use Modules\CatalogModule\Services\PortService;
use Modules\CommonModule\Traits\ApiResponseTrait;
use function view;

class PortController extends Controller
{
    use ApiResponseTrait;

    private $portService;

    public function __construct(PortService $portService)
    {
        $this->portService = $portService;
    }

    public function index(Request $request)
    {
        $ports = $this->portService->findAllForDashboard($request, false);

        return $this->apiResponse(compact('ports'));
    }

    public function store(CreatePortRequest $createPortRequest)
    {
        $result = $this->portService->create($createPortRequest);

        return $this->apiResponse($result, 201, __('Data has been added successfully'));
    }

    public function update($id, UpdatePortRequest $updatePortRequest)
    {
        $result = $this->portService->update($id, $updatePortRequest);

        return $this->apiResponse($result, 200, __('Data has been updated successfully'));
    }

    public function destroy($id)
    {
        $this->portService->delete($id);

        return $this->apiResponse([], 200, __('Data has been deleted successfully'));
    }
}
