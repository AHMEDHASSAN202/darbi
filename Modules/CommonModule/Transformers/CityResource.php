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
        return [
            'country_code'      => $this->country_code,
            'city_code'         => $this->code,
            'name'              => $this->name,
            $this->mergeWhen($this->relationLoaded('country'), [
                'country'       => new CountryResource($this->country)
            ])
        ];
    }
}
