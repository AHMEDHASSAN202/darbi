<?php

namespace Modules\CatalogModule\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Services\AttributeService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class AttributeController extends Controller
{
    use ApiResponseTrait;

    private $attributeService;


    public function __construct(AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
    }


    public function index(Request $request)
    {
        return $this->apiResponse([
            'attributes'    => $this->attributeService->findAll($request)
        ]);
    }
}
