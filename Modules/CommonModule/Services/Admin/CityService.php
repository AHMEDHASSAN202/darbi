<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Services\Admin;

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

    public function findAll(Request $request)
    {
        $cities = $this->cityRepository->findAllForDashboard($request);

        if ($cities instanceof LengthAwarePaginator) {
            return successResponse(['cities' => new PaginateResource(CityResource::collection($cities))]);
        }

        return successResponse(['cities' => CityResource::collection($cities)]);
    }

    public function toggleActive($cityId)
    {
        $city = $this->cityRepository->toggleActive($cityId);

        return updatedResponse(['id' => $city->id]);
    }
}
