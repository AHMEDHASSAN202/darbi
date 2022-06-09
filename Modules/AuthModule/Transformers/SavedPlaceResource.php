<?php

namespace Modules\AuthModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use function asset;

class SavedPlaceResource extends JsonResource
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
            'id'            => $this->_id,
            'lat'           => $this->lat,
            'lng'           => $this->lng,
            'city'          => $this->city,
            'country'       => $this->country,
            'full_address'  => $this->full_address,
            'region'        => translateAttribute($this->region->name),
            'region_id'     => $this->region_id
        ];
    }
}
