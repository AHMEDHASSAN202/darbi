<?php

namespace Modules\CatalogModule\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\CatalogModule\Entities\Yacht;
use Modules\CatalogModule\Transformers\EntityTrait;

class EntityResource extends JsonResource
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
            'image'         => $this->getMainImage(),
            'brand'         => translateAttribute(optional($this->brand)->name),
            'model'         => translateAttribute(optional($this->model)->name),
            'price'         => $this->price,
            'price_unit'    => $this->price_unit,
            'state'         => $this->state,
            'is_active'     => (boolean)$this->is_active
        ];

        if ($this->resource instanceof Yacht) {
            $res['port'] = translateAttribute(optional($this->port)->name);
            $res['port_id'] = (string)$this->port_id;
            $res['name'] = (string)translateAttribute($this->name);
        }

        return $res;
    }
}
