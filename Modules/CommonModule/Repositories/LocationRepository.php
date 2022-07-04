<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Repositories;

use Illuminate\Http\Request;
use Modules\CommonModule\Classes\GoogleFindLocation;
use Modules\CommonModule\Entities\Location;
use Modules\CommonModule\Entities\Region;
use Modules\CommonModule\Http\Requests\GetRegionsByNorthEastAndSouthWestRequest;

class LocationRepository
{
    private $model;

    public function __construct(Location $model)
    {
        $this->model = $model;
    }

    /**
     * @param float $lat
     * @param float $lng
     * @param $distance unit => m
     * @return mixed
     */
    public function findNearLocation(float $lat, float $lng, $distance = 100)
    {
        return $this->model->where('location', 'near', [
                    '$geometry' => [
                        'type' => 'Point',
                        'coordinates' => [$lng, $lat],
                    ],
                    '$maxDistance' => $distance,
                ])->first();
    }

    public function create(array $location)
    {
        return $this->model->create($location);
    }
}
