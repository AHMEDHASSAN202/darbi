<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Services;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CommonModule\Http\Requests\GetRegionByLatAndLngRequest;
use Modules\CommonModule\Repositories\RegionRepository;
use Modules\CommonModule\Transformers\PaginateResource;
use Modules\CommonModule\Transformers\RegionResource;

class RegionService
{
    private $regionRepository;

    public function __construct(RegionRepository $regionRepository)
    {
        $this->regionRepository = $regionRepository;
    }

    public function regions(Request $request)
    {
        $regions = $this->regionRepository->list($request);

        if ($regions instanceof LengthAwarePaginator) {
            return new PaginateResource(RegionResource::collection($regions));
        }

        return RegionResource::collection($regions);
    }

    public function findRegionByLatAndLng(GetRegionByLatAndLngRequest $getRegionByLatAndLngRequest)
    {
        $region = $this->regionRepository->findRegionByLatAndLng($getRegionByLatAndLngRequest);

        if (!$region) {
            return null;
        }

        return new RegionResource($region);
    }
}
