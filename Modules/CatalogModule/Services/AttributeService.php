<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CatalogModule\Repositories\AttributeRepository;
use Modules\CatalogModule\Repositories\BrandRepository;
use Modules\CatalogModule\Transformers\BrandResource;
use Modules\CatalogModule\Transformers\SpecsResource;
use Modules\CommonModule\Transformers\PaginateResource;

class AttributeService
{
    private $attributeRepository;

    public function __construct(AttributeRepository $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function findAll(Request $request)
    {
        $attributes = $this->attributeRepository->findAll($request);

        return SpecsResource::collection($attributes);
    }
}
