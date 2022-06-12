<?php

namespace Modules\CatalogModule\Http\Controllers\Admin\Vendor;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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
        $ports = $this->portService->findAllForDashboard($request);

        return $this->apiResponse(compact('ports'));
    }
}
