<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CatalogModule\Http\Requests\Admin\CreateModelRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateModelRequest;
use Modules\CatalogModule\Repositories\BrandRepository;
use Modules\CatalogModule\Repositories\ModelRepository;
use Modules\CatalogModule\Transformers\Admin\FindModelResource;
use Modules\CatalogModule\Transformers\Admin\ModelResource;
use Modules\CommonModule\Traits\ImageHelperTrait;
use Modules\CommonModule\Transformers\PaginateResource;
use MongoDB\BSON\ObjectId;

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
        $model = $this->modelRepository->findOne($id);

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
        $data['specs']  = $this->handleSpecs($createModelRequest->specs);

        $model = $this->modelRepository->create($data);

        return createdResponse(['id' => $model->_id]);
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
            'specs'      => $this->handleSpecs($updateModelRequest->specs)
        ];

        $model = $this->modelRepository->update($id, $data);

        return updatedResponse(['id' => $model->_id]);
    }

    public function delete($id)
    {
        $this->modelRepository->destroy($id);

        return deletedResponse();
    }

    public function removeImage($id, $imageIndex)
    {
        $model = $this->modelRepository->find($id);

        $images = $model->images;

        if (empty($images)) {
            return null;
        }

        $image = $images[$imageIndex];

        unset($images[$imageIndex]);

        $model->update(['images' => array_values($images)]);

        $this->_removeImage($image);

        return successResponse(['id' => $model->_id]);
    }

    private function handleSpecs(array $newSpecs)
    {
        if (empty($newSpecs)) {
            return [];
        }

        $specs = [];

        foreach ($newSpecs as $spec) {
            //add
            $specs[$spec['image']['key']] = [
                'value' => $spec['value'],
                'image' => $spec['image']
            ];
        }

        return $specs;
    }

    public function assets()
    {
        return [
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
            ],
            [
                'key'       => 'pilot',
                'value'     => 'https://i.ibb.co/1vrxW5B/pilot.png',
                'full_url'  => 'https://i.ibb.co/1vrxW5B/pilot.png',
                'name'      => 'pilot'
            ]
        ];
    }
}
