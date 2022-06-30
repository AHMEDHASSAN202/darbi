<?php

namespace Modules\CatalogModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ExtraResource extends JsonResource
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
            'plugin_id'     => (string) $this->plugin_id,
            'name'          => @$this->name ? translateAttribute($this->name) : translateAttribute(@(array)$this->plugin->name),
            'desc'          => @$this->desc ? translateAttribute($this->desc) : translateAttribute(@(array)$this->plugin->desc),
            'price'         => $this->price,
            'price_unit'    => @$this->price_unit,
            'entity_type'   => optional($this->plugin)->entity_type
        ];
    }

}
