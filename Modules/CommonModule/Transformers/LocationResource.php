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
            'lat'               => $this->lat,
            'lng'               => $this->lng,
            'city'              => $this->data['city'],
            'country'           => $this->data['country'],
            'fully_addressed'   => $this->data['fully_addressed'],
            'state'             => $this->data['state'],
        ];
    }
}
