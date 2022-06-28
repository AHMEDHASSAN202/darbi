<?php

namespace Modules\CatalogModule\Transformers;

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
            'id'              => $this->_id,
            'name'            => translateAttribute($this->name),
            'country'         => translateAttribute($this->country->name),
            'city'            => translateAttribute($this->city->name),
            'fully_addressed' => $this->fully_addressed,
            'lat'             => $this->lat,
            'lng'             => $this->lng,
        ];
    }
}
