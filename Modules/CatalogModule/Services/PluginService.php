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

    public function findAllPluginByCar($carId)
    {
        $plugins = $this->pluginRepository->findAllPluginByCar($carId);

        return PluginResource::collection($plugins);
    }
}
