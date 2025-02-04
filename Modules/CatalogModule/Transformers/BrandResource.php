<?php

namespace Modules\CatalogModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
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
            'logo'      => imageUrl($this->logo, 'thumbnail'),
        ];
    }
}
