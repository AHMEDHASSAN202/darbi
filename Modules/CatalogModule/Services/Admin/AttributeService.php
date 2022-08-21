<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services\Admin;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CatalogModule\Http\Requests\Admin\CreateAttributeRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateAttributeRequest;
use Modules\CatalogModule\Repositories\AttributeRepository;
use Modules\CatalogModule\Transformers\Admin\SpecsResource;
use Modules\CommonModule\Traits\ImageHelperTrait;
use Modules\CommonModule\Transformers\PaginateResource;
use function createdResponse;
use function deletedResponse;
use function updatedResponse;

class AttributeService
{
    use ImageHelperTrait;

    private $attributeRepository;

    public function __construct(AttributeRepository $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function findAll(Request $request)
    {
        $attributes = $this->attributeRepository->findAll($request);

        if ($attributes instanceof LengthAwarePaginator) {
            return new PaginateResource(SpecsResource::collection($attributes));
        }

        return SpecsResource::collection($attributes);
    }

    public function find($id)
    {
        $attribute = $this->attributeRepository->find($id);

        return new SpecsResource($attribute);
    }

    public function create(CreateAttributeRequest $createAttributeRequest)
    {
        $attribute = $this->attributeRepository->create([
            'key'           => $createAttributeRequest->key,
            'image'         => $this->uploadImage('attributes', $createAttributeRequest->image),
            'entity_type'   => $createAttributeRequest->entity_type,
            'type'          => $createAttributeRequest->type
        ]);

        return createdResponse(['id' => $attribute->id]);
    }

    public function update($id, UpdateAttributeRequest $updateAttributeRequest)
    {
        $data = [
            'key'           => $updateAttributeRequest->key,
            'entity_type'   => $updateAttributeRequest->entity_type,
            'type'          => $updateAttributeRequest->type
        ];

        if ($updateAttributeRequest->hasFile('image')) {
            $data['image'] = $this->uploadImage('attributes', $updateAttributeRequest->image);
        }

        $this->attributeRepository->update($data, $id);

        return updatedResponse(['id' => $id]);
    }

    public function destroy($id)
    {
        $this->attributeRepository->destroy($id);

        return deletedResponse();
    }

    public function findByIds($ids)
    {
        $attributes = $this->attributeRepository->findByIds($ids);

        return SpecsResource::collection($attributes);
    }
}
