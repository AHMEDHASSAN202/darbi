<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Services;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CommonModule\Classes\GoogleFindLocation;
use Modules\CommonModule\Http\Requests\GetRegionsByNorthEastAndSouthWestRequest;
use Modules\CommonModule\Repositories\LocationRepository;
use Modules\CommonModule\Repositories\RegionRepository;
use Modules\CommonModule\Transformers\LocationResource;
use Modules\CommonModule\Transformers\PaginateResource;
use Modules\CommonModule\Transformers\RegionResource;

class LocationService
{
    private $locationRepository;

    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    public function handleLocation($lat, $lng)
    {
        //check if location exists in darbi database
        $location = $this->locationRepository->findLocation($lat, $lng);

        if (!$location) {
            $location = $this->locationRepository->create((new GoogleFindLocation($lat, $lng)));
        }

        return new LocationResource($location);
    }
}
