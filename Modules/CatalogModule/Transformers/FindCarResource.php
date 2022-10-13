<?php

namespace Modules\CatalogModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\CommonModule\Transformers\CarTypeResource;

class FindCarResource extends JsonResource
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
        return [
            'id'            => $this->_id,
            'images'        => $this->getImagesFullPath(),
            'brand'         => translateAttribute(optional($this->brand)->name),
            'model'         => translateAttribute(optional($this->model)->name),
            'price'         => $this->price,
            'price_unit'    => $this->price_unit,
            'currency_code' => optional($this->branch)->currency_code ?? optional($this->vendor)->country_currency_code,
            'extras'        => $this->getExtras(),
            'state'         => $this->state,
            'specs'         => $this->getAttributes(),
            'vendor'        => $this->getVendor(),
            'branch_id'     => (string)$this->branch_id,
            'built_date'    => $this->built_date ? (int)$this->built_date : null,
            'color'         => (!empty($this->color) && is_array($this->color)) ? $this->color : [],
            'car_type_id'   => (string)$this->car_type_id,
            'car_type'      => new CarTypeResource($this->car_type)
        ];
    }
}
