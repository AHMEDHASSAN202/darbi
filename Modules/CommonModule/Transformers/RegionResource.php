<?php

namespace Modules\CommonModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class RegionResource extends JsonResource
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
            'city_id'           => (string)$this->city_id,
            'name'              => translateAttribute($this->name),
        ];

        if ($this->relationLoaded('country')) {
            $res['country'] = new CountryResource($this->country);
        }

        if ($this->relationLoaded('city')) {
            $res['city'] = new CityResource($this->city);
        }

        return $res;
    }
}
