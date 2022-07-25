<?php

namespace Modules\CommonModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
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
            'lat'               => @$this->location['coordinates'][1],
            'lng'               => @$this->location['coordinates'][0],
            'city'              => $this->city,
            'country'           => $this->country,
            'fully_addressed'   => $this->fully_addressed,
            'name'              => $this->name
        ];
    }
}
