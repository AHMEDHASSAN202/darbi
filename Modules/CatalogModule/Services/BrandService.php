<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CatalogModule\Repositories\BrandRepository;
use Modules\CatalogModule\Transformers\BrandResource;
use Modules\CommonModule\Transformers\PaginateResource;

class BrandService
{
    private $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function findAll(Request $request)
    {
        $brands = $this->brandRepository->listOfBrands($request);

        if ($brands instanceof LengthAwarePaginator) {
            return new PaginateResource(BrandResource::collection($brands));
        }

        return BrandResource::collection($brands);
    }
}
