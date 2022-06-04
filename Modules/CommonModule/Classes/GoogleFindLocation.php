<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Classes;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleFindLocation
{
    private $lat;
    private $lng;
    private $data = [];

    public function __construct($lat, $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
        $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&sensor=false";
//        try {
            $this->data = Http::get($url)->json();
//            dd($this->data);
//        }catch (\Exception $exception) {
//            Log::error('google can\'t get location: ' . $exception->getMessage());
//        }
    }

    public function fullAddress()
    {

    }


    function findLongNameGivenType($type, $array, $short_name = false) {
        foreach($array as $value) {
            if (in_array($type, $value["types"])) {
                if ($short_name)
                    return $value["short_name"];
                return $value["long_name"];
            }
        }
    }
}
