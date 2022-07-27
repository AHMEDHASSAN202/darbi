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

class HomeService
{
    public function getHomeData(Request $request)
    {
        return [
            'brands'         => app(BrandService::class)->findAll($request)->toArray($request)
        ];
    }
}
