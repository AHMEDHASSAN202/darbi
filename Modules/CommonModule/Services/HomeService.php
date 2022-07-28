<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Services;

use Illuminate\Http\Request;
use Modules\CatalogModule\Services\BrandService;

class HomeService
{
    public function getHomeData(Request $request)
    {
        return [
            'brands'         => app(BrandService::class)->findAll($request)->toArray($request)
        ];
    }
}
