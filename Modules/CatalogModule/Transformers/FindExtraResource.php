<?php

namespace Modules\CatalogModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class FindExtraResource extends JsonResource
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
            'name'          => @(array)$this->name ?? @(array)$this->plugin->name,
            'desc'          => @(array)$this->desc ?? @(array)$this->plugin->desc,
            'price'         => $this->price,
            'price_unit'    => @$this->price_unit,
            'entity_type'   => optional($this->plugin)->entity_type
        ];
    }

}
