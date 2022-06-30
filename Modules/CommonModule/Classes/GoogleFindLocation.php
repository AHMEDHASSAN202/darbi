<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Classes;

use Illuminate\Support\Facades\Http;

class GoogleFindLocation
{
    private $lat;
    private $lng;
    private $data = [];

    public function __construct($lat, $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&sensor=false&key=".env('GOOGLE_APY_KEY', 'AIzaSyAvu65Z2l4JR6t9p3Vq-MI2AgULAQZCvTk');
        try {
            $this->data = Http::retry(2)->get($url)->json();
        }catch (\Exception $exception) {
            Log::error('google can\'t get location: ' . $exception->getMessage());
        }
    }

    public function fullAddress()
    {
        return [
            'country' => $this->getCountry(),
            'province' => $this->getProvince(),
            'city' => $this->getCity(),
            'country_code' => $this->getCountryCode(),
            'formatted_address' => $this->getAddress(),
        ];
    }

    public function getCountry($short_name = false)
    {
        return $this->findLongNameGivenType('country', $this->data["results"][1]["address_components"], $short_name);
    }

    public function getProvince($short_name = false)
    {
        return $this->findLongNameGivenType('administrative_area_level_1', $this->data["results"][1]["address_components"], $short_name);
    }

    public function getCity($short_name = false)
    {
        return $this->findLongNameGivenType('administrative_area_level_2', $this->data["results"][1]["address_components"], $short_name) ??
               $this->findLongNameGivenType('administrative_area_level_2', $this->data["results"][2]["address_components"], $short_name);
    }

    public function getCountryCode()
    {
        return $this->getCountry(true);
    }

    public function getAddress()
    {
        return $this->data["results"][1]["formatted_address"];
    }

    public function getName()
    {
        return $this->data["results"][2]["formatted_address"];
    }

    public function getAllData()
    {
        return $this->data;
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
