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

        return $this->apiResponse($result, 201, __('Data has been added successfully'));
    }

    public function update($id, UpdateModelRequest $updateModelRequest)
    {
        $result = $this->modelService->update($id, $updateModelRequest);

        return $this->apiResponse($result, 200, __('Data has been updated successfully'));
    }

    public function destroy($id)
    {
        $this->modelService->delete($id);

        return $this->apiResponse([], 200, __('Data has been deleted successfully'));
    }


    public function deleteImage($id, $imageIndex)
    {
        $this->modelService->removeImage($id, $imageIndex);

        return $this->apiResponse([], 200, __('Data has been deleted successfully'));
    }


    public function assets()
    {
        return $this->apiResponse([
            'assets'    => [
                [
                    'key'       => 'engine_type',
                    'value'     => 'https://i.ibb.co/q0bSNT5/liter.png',
                    'full_url'  => 'https://i.ibb.co/q0bSNT5/liter.png',
                    'name'      => 'engine_type'
                ],
                [
                    'key'       => 'seats',
                    'value'     => 'https://i.ibb.co/N1tNCy4/bedroom.png',
                    'full_url'  => 'https://i.ibb.co/N1tNCy4/bedroom.png',
                    'name'      => 'seats'
                ],
                [
                    'key'       => 'passengers',
                    'value'     => 'https://i.ibb.co/nBjwmhP/passengers.png',
                    'full_url'  => 'https://i.ibb.co/nBjwmhP/passengers.png',
                    'name'      => 'passengers'
                ]
            ]
        ]);
    }
}
