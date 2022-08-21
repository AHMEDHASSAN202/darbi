<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services;

use Modules\CatalogModule\Repositories\AttributeRepository;
use Modules\CatalogModule\Transformers\SpecsResource;
use Modules\CommonModule\Traits\ImageHelperTrait;

class AttributeService
{
    use ImageHelperTrait;

    private $attributeRepository;

    public function __construct(AttributeRepository $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function findByIds($ids)
    {
        $attributes = $this->attributeRepository->findByIds($ids);

        return SpecsResource::collection($attributes);
    }
}
