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
            'images'    => imagesUrl($this->images),
            'is_active' => (boolean)$this->active,
            'specs'     => $this->specs,
            'entity_type' => $this->entity_type
        ];
    }
}
