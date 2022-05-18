<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CatalogModule\Repositories\BrandRepository;
use Modules\CatalogModule\Repositories\CarRepository;
use Modules\CatalogModule\Transformers\BrandResource;
use Modules\CatalogModule\Transformers\CarResource;
use Modules\CommonModule\Traits\ImageHelperTrait;
use Modules\CommonModule\Transformers\PaginateResource;
use Modules\VendorModule\Http\Requests\CreateUserRequest;
use Modules\VendorModule\Http\Requests\UpdateUserRequest;
use Modules\VendorModule\Repositories\UserRepository;
use Modules\VendorModule\Transformers\UserResource;

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
