<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services\Admin;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CatalogModule\Repositories\BrandRepository;
use Modules\CatalogModule\Transformers\Admin\BrandResource;
use Modules\CommonModule\Transformers\PaginateResource;

class BrandService
{
    private $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function findAllForDashboard(Request $request, $onlyActive = true)
    {
        $wheres = [];
        if ($onlyActive) {
            $wheres['is_active'] = true;
        }
        $brands = $this->brandRepository->listOfBrandsForDashboard($request, $wheres);

        if ($brands instanceof LengthAwarePaginator) {
            return new PaginateResource(BrandResource::collection($brands));
        }

        return BrandResource::collection($brands);
    }
}
