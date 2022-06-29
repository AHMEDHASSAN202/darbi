<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services\Admin;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CatalogModule\Http\Requests\Admin\CreateModelRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateModelRequest;
use Modules\CatalogModule\Repositories\BrandRepository;
use Modules\CatalogModule\Repositories\ModelRepository;
use Modules\CatalogModule\Transformers\Admin\FindModelResource;
use Modules\CatalogModule\Transformers\Admin\ModelResource;
use Modules\CommonModule\Traits\ImageHelperTrait;
use Modules\CommonModule\Transformers\PaginateResource;

class ModelService
{
    use ImageHelperTrait;

    private $modelRepository;
    private $uploadDirectory = 'models';

    public function __construct(ModelRepository $modelRepository)
    {
        $this->modelRepository = $modelRepository;
    }

    public function findAllForDashboard(Request $request, $onlyActive = true)
    {
        $wheres = [];
        if ($onlyActive) {
            $wheres['is_active'] = true;
        }

        $models = $this->modelRepository->listOfModelsForDashboard($request, $wheres);

        if ($models instanceof LengthAwarePaginator) {
            return new PaginateResource(ModelResource::collection($models));
        }

        return ModelResource::collection($models);
    }

    public function findAll(Request $request)
    {
        return $this->findAllForDashboard($request, false);
    }

    public function find($id)
    {
        $model = $this->modelRepository->find($id);

        return new FindModelResource($model);
    }

    public function create(CreateModelRequest $createModelRequest)
    {
        $brand = app(BrandRepository::class)->find($createModelRequest->brand_id);
        $data['brand_id'] = $createModelRequest->brand_id;
        $data['name']   = $createModelRequest->name;
        $data['images'] = $this->uploadImages($this->uploadDirectory, $createModelRequest->images);
        $data['is_active'] = ($createModelRequest->is_active === null) || (boolean)$createModelRequest->is_active;
        $data['entity_type'] = $brand->entity_type;
        $data['specs']  = !empty($createModelRequest->specs) ? $createModelRequest->specs : [];

        $model = $this->modelRepository->create($data);

        return [
            'id'    => $model->_id
        ];
    }

    public function update($id, UpdateModelRequest $updateModelRequest)
    {
        $brand = app(BrandRepository::class)->find($updateModelRequest->brand_id);
        $model = $this->modelRepository->find($id);
        $images = $model->images ?? [];
        $data = [
            'brand_id'   => $updateModelRequest->brand_id,
            'name'       => $updateModelRequest->name,
            'is_active'  => ($updateModelRequest->is_active === null) || (boolean)$updateModelRequest->is_active,
            'entity_type'=> $brand->entity_type,
            'images'     => array_merge($images, $this->uploadImages($this->uploadDirectory, $updateModelRequest->images)),
            'specs'      => !empty($updateModelRequest->specs) ? $updateModelRequest->specs : []
        ];

        $model = $this->modelRepository->update($id, $data);

        return [
            'id'    => $model->_id
        ];
    }

    public function delete($id)
    {
        return $this->modelRepository->destroy($id);
    }

    public function removeImage($id, $imageIndex)
    {
        $model = $this->modelRepository->find($id);

        $images = $model->images;

        if (empty($images)) {
            return null;
        }

        unset($images[$imageIndex]);
        $model->update(['images' => array_values($images)]);

        return [
            'id'    => $model->_id
        ];
    }
}
