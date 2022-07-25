<?php

namespace Modules\CatalogModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class FindYachtResource extends JsonResource
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
            'name'          => translateAttribute($this->name),
            'images'        => $this->getImagesFullPath(),
            'price'         => $this->price,
            'price_unit'    => $this->price_unit,
            'state'         => $this->state,
            'built_date'    => $this->built_date,
            'port'          => translateAttribute(optional($this->port)->name),
            'extras'        => $this->getExtras(),
            'specs'         => optional($this->model)->specs ? SpecsResource::collection(@array_values($this->model->specs)) : [],
            'vendor'        => $this->getVendor()
        ];
    }
}
