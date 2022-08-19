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
        $specs = array_values(objectGet($this->model, 'specs', [])) + $this->getAttributes();

        return [
            'id'            => $this->_id,
            'name'          => translateAttribute($this->name),
            'images'        => $this->getImagesFullPath(),
            'price'         => $this->price,
            'price_unit'    => $this->price_unit,
            'state'         => $this->state,
            'built_date'    => $this->built_date ? (int)$this->built_date : null,
            'port'          => translateAttribute(optional($this->port)->name),
            'extras'        => $this->getExtras(),
            'specs'         => @SpecsResource::collection($specs) ?? [],
            'vendor'        => $this->getVendor()
        ];
    }
}
