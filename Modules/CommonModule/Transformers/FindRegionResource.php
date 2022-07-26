<?php

namespace Modules\CommonModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class FindRegionResource extends JsonResource
{
    use HelperRegionResource;

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
            'name'              => translateAttribute($this->name),
            'location'          => $this->getLocationPoints(),
            'is_active'         => (boolean)$this->is_active
        ];
    }
}
