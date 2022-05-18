<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Services;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CommonModule\Repositories\CityRepository;
use Modules\CommonModule\Transformers\CityResource;
use Modules\CommonModule\Transformers\PaginateResource;

class CityService
{
    private $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function cities(Request $request)
    {
        $cities = $this->cityRepository->list($request);

        if ($cities instanceof LengthAwarePaginator) {
            return new PaginateResource(CityResource::collection($cities));
        }

        return CityResource::collection($cities);
    }
}
