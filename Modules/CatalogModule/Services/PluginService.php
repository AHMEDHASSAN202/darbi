<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services;

use Modules\CatalogModule\Repositories\PluginRepository;
use Modules\CatalogModule\Transformers\PluginResource;

class PluginService
{
    private $pluginRepository;

    public function __construct(PluginRepository $pluginRepository)
    {
        $this->pluginRepository = $pluginRepository;
    }

    public function findAllPlugin($entityId)
    {
        $plugins = $this->pluginRepository->findAllPlugin($entityId);

        return PluginResource::collection($plugins);
    }
}
