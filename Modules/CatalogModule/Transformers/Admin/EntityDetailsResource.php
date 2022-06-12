<?php

namespace Modules\CatalogModule\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\CatalogModule\Entities\Yacht;
use Modules\CatalogModule\Transformers\EntityTrait;

class EntityDetailsResource extends JsonResource
{
    use EntityTrait;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $res = [
            'id'            => $this->_id,
            'images'        => $this->getImagesFullPath(),
            'brand'         => translateAttribute(optional($this->brand)->name),
            'brand_id'      => (string)$this->brand_id,
            'model'         => translateAttribute(optional($this->model)->name),
            'model_id'      => (string)$this->model_id,
            'price'         => $this->price,
            'price_unit'    => $this->price_unit,
            'state'         => $this->state,
            'is_active'     => (boolean)$this->is_active,
            'unavailable_date'  => $this->unavailable_date,
            'country_id'    => (string)$this->country_id,
            'city_id'       => (string)$this->city_id,
            'plugin_ids'    => $this->plugin_ids,
            'branch_ids'    => $this->branch_ids
        ];

        if ($this->resource instanceof Yacht) {
            $res['port_id'] = (string)$this->port_id;
            $res['port']    = translateAttribute(optional($this->port)->name);
            $res['name']    = $this->name;
        }

        return $res;
    }
}
