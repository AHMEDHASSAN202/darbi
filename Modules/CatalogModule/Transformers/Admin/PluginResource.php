<?php

namespace Modules\CatalogModule\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PluginResource extends JsonResource
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
            'id'            => (string)$this->_id,
            'name'          => translateAttribute($this->name),
            'desc'          => translateAttribute($this->desc),
            'entity_type'   => $this->entity_type,
            'is_active'     => (bool)$this->is_active
        ];
    }

}
