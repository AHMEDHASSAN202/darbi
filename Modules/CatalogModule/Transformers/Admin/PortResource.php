<?php

namespace Modules\CatalogModule\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PortResource extends JsonResource
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
            'name'      => translateAttribute($this->name),
            'country_id'=> (string)$this->country_id,
            'country'   => translateAttribute(optional($this->country)->name),
            'city_id'   => (string)$this->city_id,
            'city'      => translateAttribute(optional($this->city)->name),
            'lat'       => $this->lat,
            'lng'       => $this->lng,
            'is_active' => (boolean)$this->is_active
        ];
    }
}
