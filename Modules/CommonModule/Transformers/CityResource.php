<?php

namespace Modules\CommonModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $res = [
            'id'                => $this->_id,
            'country_id'        => (string)$this->country_id,
            'country_code'      => (string)$this->country_code,
            'city_code'         => $this->code,
            'name'              => translateAttribute($this->name),
            'lat'               => $this->lat,
            'lng'               => $this->lng,
            'is_active'         => (boolean)$this->is_active,
            'image'             => objectGet($this->country, 'image') ? imageUrl($this->country->image) : null
        ];

        if ($this->relationLoaded('country')) {
            $res['country'] = new CountryResource($this->country);
        }

        return $res;
    }
}
