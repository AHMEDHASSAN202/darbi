<?php

namespace Modules\CatalogModule\Http\Controllers\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Entities\Plugin;
use Modules\CatalogModule\Services\PluginService;
use Modules\CatalogModule\Transformers\PluginResource;
use Modules\CommonModule\Traits\ApiResponseTrait;

class PluginController extends Controller
{
    use ApiResponseTrait;

    private $pluginService;

    public function __construct(PluginService $pluginService)
    {
        $this->pluginService = $pluginService;
    }

    public function findAllPlugin($entityId)
    {
        return $this->apiResponse([
            'plugins'   => $this->pluginService->findAllPlugin($entityId)
        ]);
    }
}
