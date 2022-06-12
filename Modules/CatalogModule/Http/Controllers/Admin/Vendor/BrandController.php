<?php

namespace Modules\CatalogModule\Http\Controllers\Admin\Vendor;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Services\BrandService;
use Modules\CatalogModule\Services\PluginService;
use Modules\CommonModule\Traits\ApiResponseTrait;
use function view;

class BrandController extends Controller
{
    use ApiResponseTrait;

    private $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    public function index(Request $request)
    {
        $brands = $this->brandService->findAllForDashboard($request);

        return $this->apiResponse(compact('brands'));
    }
}
