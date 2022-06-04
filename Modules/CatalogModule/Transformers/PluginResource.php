<?php

namespace Modules\CatalogModule\Transformers;

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
            'id'            => $this->_id,
            'name'          => translateAttribute($this->name),
            'price'         => $this->price,
            'price_unit'    => $this->price_unit,
//            'price_label'   => generatePriceLabelFromPrice($this->price, $this->price_unit)
        ];
    }
}
