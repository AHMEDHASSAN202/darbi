<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Services;

use Modules\CommonModule\Classes\GoogleFindLocation;
use Modules\CommonModule\Repositories\LocationRepository;
use Modules\CommonModule\Transformers\LocationResource;
use MongoDB\BSON\ObjectId;

class LocationService
{
    private $locationRepository;

    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    public function handleLocation($lat, $lng)
    {
        //get region
        $regionService = new RegionService();
        $region = $regionService->findRegionByLatAndLng($lat, $lng);
        if (!$region) {
            //region not supported
            return [
                'data'       => [],
                'message'    => 'your region not supported',
                'statusCode' => 400
            ];
        }

        //check if location exists in darbi database
        $location = $this->locationRepository->findLocation($lat, $lng);

        if (!$location) {
            $geoLocation = new GoogleFindLocation($lat, $lng);
            $locationInfo['country']    = $geoLocation->getCountry();
            $locationInfo['city']       = $geoLocation->getCity();
            $locationInfo['fully_addressed'] =  $geoLocation->getAddress();
            $locationInfo['name'] =  $geoLocation->getName();
            $locationInfo['lat']        = $lat;
            $locationInfo['lng']        = $lng;
            $locationInfo['region_id']  = new ObjectId($region->id);
            $location = $this->locationRepository->create($locationInfo);
        }

        return [
            'data'       => [
                'location'  => new LocationResource($location)
            ],
            'message'    => '',
            'statusCode' => 200
        ];
    }
}
