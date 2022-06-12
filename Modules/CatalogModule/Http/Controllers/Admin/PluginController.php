<?php

namespace Modules\CatalogModule\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Http\Requests\Admin\CreatePluginRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdatePluginRequest;
use Modules\CatalogModule\Services\PluginService;
use Modules\CommonModule\Traits\ApiResponseTrait;
use function view;

class PluginController extends Controller
{
    use ApiResponseTrait;

    private $pluginService;

    public function __construct(PluginService $pluginService)
    {
        $this->pluginService = $pluginService;
    }

    public function index(Request $request)
    {
        $plugins = $this->pluginService->list($request, false);

        return $this->apiResponse(compact('plugins'));
    }



    public function store(CreatePluginRequest $createPluginRequest)
    {
        $plugin = $this->pluginService->create($createPluginRequest);

        return $this->apiResponse(compact('plugin'), 201, __('Data has been added successfully'));
    }


    public function show($id)
    {
        $plugin = $this->pluginService->find($id);

        return $this->apiResponse(compact('plugin'));
    }



    public function update(UpdatePluginRequest $updatePluginRequest, $id)
    {
        $plugin = $this->pluginService->update($id, $updatePluginRequest);

        return $this->apiResponse(compact('plugin'), 200, __('Data has been updated successfully'));
    }


    public function destroy($id)
    {
        $this->pluginService->delete($id);

        return $this->apiResponse([], 200, __('Data has been deleted successfully'));
    }
}
