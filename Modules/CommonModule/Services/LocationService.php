<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Services;

use Modules\CommonModule\Classes\GoogleFindLocation;
use Modules\CommonModule\Repositories\LocationRepository;
use Modules\CommonModule\Transformers\LocationResource;


class LocationService
{
    private $locationRepository;

    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    public function handleLocation($lat, $lng)
    {
        try {
            //check if location exists in darbi database
            $location = $this->locationRepository->findNearLocation((float)$lat, (float)$lng);

            if (!$location) {
                $geoLocation = new GoogleFindLocation($lat, $lng);
                $locationInfo['country']    = $geoLocation->getCountry();
                $locationInfo['city']       = $geoLocation->getCity();
                $locationInfo['fully_addressed'] =  $geoLocation->getAddress();
                $locationInfo['name'] =  $geoLocation->getName();
                $locationInfo['location'] = [
                    'type'          => 'Point',
                    'coordinates'   => [(float)$lng, (float)$lat]
                ];
                $location = $this->locationRepository->create($locationInfo);
            }

            return successResponse(['location'  => new LocationResource($location)]);

        }catch (\Exception $exception) {
            helperLog(__CLASS__, __FUNCTION__, $exception->getMessage());
            return serverErrorResponse();
        }
    }
}
