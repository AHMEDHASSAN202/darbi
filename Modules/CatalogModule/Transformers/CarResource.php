<?php

namespace Modules\CatalogModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
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
            'image'         => $this->getMainImage(),
            'brand'         => translateAttribute(optional($this->brand)->name),
            'model'         => translateAttribute(optional($this->model)->name),
            'price'         => $this->price,
            'price_unit'    => $this->price_unit,
            'state'         => $this->state,
            'currency_code' => optional($this->country)->currency_code
        ];
    }
}
