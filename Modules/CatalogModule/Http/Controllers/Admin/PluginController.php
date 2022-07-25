<?php

namespace Modules\CatalogModule\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Http\Requests\Admin\CreatePluginRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdatePluginRequest;
use Modules\CatalogModule\Services\Admin\PluginService;
use Modules\CommonModule\Traits\ApiResponseTrait;

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
        $result = $this->pluginService->create($createPluginRequest);

        return $this->apiResponse(...$result);
    }


    public function show($id)
    {
        $plugin = $this->pluginService->find($id);

        return $this->apiResponse(compact('plugin'));
    }


    public function update(UpdatePluginRequest $updatePluginRequest, $id)
    {
        $result = $this->pluginService->update($id, $updatePluginRequest);

        return $this->apiResponse(...$result);
    }


    public function destroy($id)
    {
        $result = $this->pluginService->delete($id);

        return $this->apiResponse(...$result);
    }
}
