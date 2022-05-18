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
        return [
            'id'                => $this->_id,
            'country_id'        => $this->country_id,
            'city_id'           => $this->city_id,
            'name'              => translateAttribute($this->name),
            $this->mergeWhen($this->relationLoaded('country'), [
                'country'       => new CountryResource($this->country)
            ]),
            $this->mergeWhen($this->relationLoaded('city'), [
                'city'          => new CityResource($this->city)
            ])
        ];
    }
}
