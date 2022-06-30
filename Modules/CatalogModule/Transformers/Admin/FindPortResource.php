<?php

namespace Modules\CatalogModule\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\CommonModule\Transformers\CityResource;
use Modules\CommonModule\Transformers\CountryResource;

class FindPortResource extends JsonResource
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
            'id'        => $this->_id,
            'name'      => $this->name,
            'country_id'=> (string)$this->country_id,
            'country'   => new CountryResource($this->country),
            'city_id'   => (string)$this->city_id,
            'city'      => new CityResource($this->city),
            'lat'       => $this->lat,
            'lng'       => $this->lng,
            'is_active' => (boolean)$this->is_active
        ];
    }
}
