<?php

namespace Modules\CatalogModule\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Http\Requests\Admin\CreateAttributeRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateAttributeRequest;
use Modules\CatalogModule\Services\Admin\AttributeService;
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

    public function show($id)
    {
        return $this->apiResponse([
            'attribute'     => $this->attributeService->find($id)
        ]);
    }

    public function store(CreateAttributeRequest $attributeRequest)
    {
        $result = $this->attributeService->create($attributeRequest);

        return $this->apiResponse(...$result);
    }

    public function update($id, UpdateAttributeRequest $attributeRequest)
    {
        $result = $this->attributeService->update($id, $attributeRequest);

        return $this->apiResponse(...$result);
    }

    public function destroy($id)
    {
        $result = $this->attributeService->destroy($id);

        return $this->apiResponse(...$result);
    }
}
