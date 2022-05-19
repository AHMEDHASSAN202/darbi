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
            'place_label'   => translateAttribute($this->region->name) . ', ' . $this->city . ', ' . $this->country,
            'lat'           => $this->lat,
            'lng'           => $this->lng,
            'city'          => $this->city,
            'country'       => $this->country,
            'region'        => translateAttribute($this->region->name),
            'region_id'     => $this->region_id
        ];
    }
}
