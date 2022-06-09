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

    public function findLocation($lat, $lng)
    {
        //find location
        return [];
    }

    public function create(GoogleFindLocation $googleFindLocation)
    {
        //create new location
        return [];
    }
}
