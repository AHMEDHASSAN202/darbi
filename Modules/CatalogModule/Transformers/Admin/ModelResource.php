<?php

namespace Modules\CatalogModule\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;


class ModelResource extends JsonResource
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
            'brand_id'  => (string)$this->brand_id,
            'brand'     => new BrandResource($this->brand),
            'images'    => imagesUrl($this->images, 'thumbnail'),
            'is_active' => (boolean)$this->is_active,
            'entity_type' => $this->entity_type
        ];
    }
}
