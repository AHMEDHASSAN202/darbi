<?php

namespace Modules\CatalogModule\Http\Controllers\Admin\Vendor;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Services\Admin\BrandService;
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
        $result = $this->brandService->findAllForDashboard($request);

        return $this->apiResponse(...$result);
    }
}
