<?php

namespace Modules\CatalogModule\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Http\Requests\Admin\CreateModelRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateModelRequest;
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
        $models = $this->modelService->findAll($request);

        return $this->apiResponse(compact('models'));
    }

    public function show($modelId)
    {
        return $this->apiResponse([
            'model'      => $this->modelService->find($modelId)
        ]);
    }

    public function store(CreateModelRequest $createModelRequest)
    {
        $result = $this->modelService->create($createModelRequest);

        return $this->apiResponse(...$result);
    }

    public function update($id, UpdateModelRequest $updateModelRequest)
    {
        $result = $this->modelService->update($id, $updateModelRequest);

        return $this->apiResponse(...$result);
    }

    public function destroy($id)
    {
        $result = $this->modelService->delete($id);

        return $this->apiResponse(...$result);
    }


    public function deleteImage($id, $imageIndex)
    {
        $result = $this->modelService->removeImage($id, $imageIndex);

        return $this->apiResponse(...$result);
    }


    public function assets(Request $request)
    {
        return $this->apiResponse([
            'assets'    => $this->modelService->assets($request)
        ]);
    }
}
