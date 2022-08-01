<?php

namespace Modules\CatalogModule\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\CatalogModule\Entities\Car;
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
            'vendor_id'     => (string)$this->vendor_id,
            'vendor_name'   => translateAttribute(optional($this->vendor)->name),
            'name'          => translateAttribute($this->name),
            'image'         => $this->getMainImage('thumbnail'),
            'brand'         => translateAttribute(optional($this->brand)->name),
            'model'         => translateAttribute(optional($this->model)->name),
            'price'         => $this->price,
            'price_unit'    => $this->price_unit,
            'state'         => $this->state,
            'is_active'     => (boolean)$this->is_active,
            'built_date'    => $this->built_date ? (int)$this->built_date : null
        ];

        if ($this->resource instanceof Yacht) {
            $res['port'] = translateAttribute(optional($this->port)->name);
            $res['port_id'] = (string)$this->port_id;
        }elseif ($this->resource instanceof Car) {
            $res['branch'] = translateAttribute(optional($this->branch)->name);
            $res['branch_id'] = (string)$this->branch_id;
        }

        return $res;
    }
}
