<?php

namespace Modules\CatalogModule\Http\Controllers\Admin\Vendor;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Http\Requests\Admin\CreateExtraRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateExtraRequest;
use Modules\CatalogModule\Services\ExtraService;
use Modules\CatalogModule\Services\PluginService;
use Modules\CommonModule\Traits\ApiResponseTrait;
use function view;

class ExtraController extends Controller
{
    use ApiResponseTrait;

    private $extraService;

    public function __construct(ExtraService $extraService)
    {
        $this->extraService = $extraService;
    }

    public function index(Request $request)
    {
        $extras = $this->extraService->list($request);

        return $this->apiResponse(compact('extras'));
    }


    public function store(CreateExtraRequest $createExtraRequest)
    {
        $extra = $this->extraService->create($createExtraRequest);

        return $this->apiResponse(compact('extra'), 201, __('Data has been added successfully'));
    }


    public function update($id, UpdateExtraRequest $updateExtraRequest)
    {
        $extra = $this->extraService->update($id, $updateExtraRequest);

        return $this->apiResponse(compact('extra'), 200, __('Data has been updated successfully'));
    }

    public function destroy($id)
    {
        $this->extraService->delete($id);

        return $this->apiResponse([], 200, __('Data has been deleted successfully'));
    }
}
