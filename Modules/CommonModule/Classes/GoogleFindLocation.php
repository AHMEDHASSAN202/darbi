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
    private $key = 'AIzaSyCpDF8paUkoqSGXA5nYQ3-qJ8SfE02wKG0';

    public function __construct($lat, $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&sensor=false&key=".$this->key;
//        try {
            $this->data = Http::get($url)->json();
            dd($this->data);
//        }catch (\Exception $exception) {
//            Log::error('google can\'t get location: ' . $exception->getMessage());
//        }
    }

    public function fullAddress()
    {
        return [
            'country' => $this->getCountry(),
            'province' => $this->getProvince(),
            'city' => $this->getCity(),
            'street' => $this->getStreet(),
            'postal_code' => $this->getPostalCode(),
            'country_code' => $this->getCountryCode(),
            'formatted_address' => $this->getAddress(),
        ];
    }

    public function getCountry($short_name = false)
    {
        return $this->findLongNameGivenType('country', $this->data["results"][0]["address_components"], $short_name);
    }

    public function getProvince($short_name = false)
    {
        return $this->findLongNameGivenType('administrative_area_level_1', $this->data["results"][0]["address_components"], $short_name);
    }

    public function getCity($short_name = false)
    {
        return $this->findLongNameGivenType('locality', $this->data["results"][0]["address_components"], $short_name);
    }

    public function getStreet($short_name = false)
    {
        return $this->findLongNameGivenType('street_number', $this->data["results"][0]["address_components"], $short_name) . ' ' . $this->findLongNameGivenType('route', $this->data["results"][0]["address_components"], $short_name);
    }

    public function getPostalCode()
    {
        return $this->findLongNameGivenType('postal_code', $this->data["results"][0]["address_components"]);
    }

    public function getCountryCode()
    {
        return $this->getCountry(true);
    }

    public function getAddress()
    {
        return $this->data["results"][0]["formatted_address"];
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
