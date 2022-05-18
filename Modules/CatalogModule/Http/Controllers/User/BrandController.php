<?php

namespace Modules\CatalogModule\Http\Controllers\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Services\BrandService;
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
        return $this->apiResponse([
            'brands'    => $this->brandService->findAll($request)
        ]);
    }
}
