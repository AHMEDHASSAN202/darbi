<?php

namespace Modules\CatalogModule\Http\Controllers\Admin\Vendor;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Services\Admin\ModelService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class ModelController extends Controller
{
    use ApiResponseTrait;

    private $modelService;

    public function __construct(ModelService $modelService)
    {
        $this->modelService = $modelService;
    }

    public function index(Request $request)
    {
        $models = $this->modelService->findAllForDashboard($request);

        return $this->apiResponse(compact('models'));
    }
}
