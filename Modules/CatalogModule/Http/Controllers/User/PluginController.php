<?php

namespace Modules\CatalogModule\Http\Controllers\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Entities\Plugin;
use Modules\CatalogModule\Transformers\PluginResource;
use Modules\CommonModule\Traits\ApiResponseTrait;

class PluginController extends Controller
{
    use ApiResponseTrait;

    public function __construct()
    {

    }

    public function findAllPluginByCar($carId)
    {
        return $this->apiResponse([
            'plugins'   => PluginResource::collection(Plugin::active()->limit(5)->get())
        ]);
    }
}
