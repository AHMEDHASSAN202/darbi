<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Services;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CommonModule\Http\Requests\GetRegionsByNorthEastAndSouthWestRequest;
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

    public function findRegionsByNorthEastAndSouthWest(GetRegionsByNorthEastAndSouthWestRequest $getRegionsByNorthEastAndSouthWest)
    {
        $mapBounds = $getRegionsByNorthEastAndSouthWest->mapBounds;

        $coordinates = [
            [(float)$mapBounds['northEast']['lng'], (float)$mapBounds['northEast']['lat']],
            [(float)$mapBounds['northEast']['lng'], (float)$mapBounds['southWest']['lat']],
            [(float)$mapBounds['southWest']['lng'], (float)$mapBounds['southWest']['lat']],
            [(float)$mapBounds['southWest']['lng'], (float)$mapBounds['northEast']['lat']],
            [(float)$mapBounds['northEast']['lng'], (float)$mapBounds['northEast']['lat']],
        ];

        $regions = $this->regionRepository->findRegionsByNorthEastAndSouthWest($coordinates);

        return RegionResource::collection($regions);
    }
}
