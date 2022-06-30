<?php

namespace Modules\CatalogModule\Http\Controllers\Admin\Vendor;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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
        $plugins = $this->pluginService->list($request, true);

        return $this->apiResponse(compact('plugins'));
    }
}
