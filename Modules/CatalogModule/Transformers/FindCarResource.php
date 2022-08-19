<?php

namespace Modules\CatalogModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

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
        $specs = array_values(objectGet($this->model, 'specs', [])) + $this->getAttributes();

        return [
            'id'            => $this->_id,
            'images'        => $this->getImagesFullPath(),
            'brand'         => translateAttribute(optional($this->brand)->name),
            'model'         => translateAttribute(optional($this->model)->name),
            'price'         => $this->price,
            'price_unit'    => $this->price_unit,
            'extras'        => $this->getExtras(),
            'state'         => $this->state,
            'specs'         => @SpecsResource::collection($specs) ?? [],
            'vendor'        => $this->getVendor(),
            'branch_id'     => (string)$this->branch_id,
            'built_date'    => $this->built_date ? (int)$this->built_date : null,
        ];
    }
}
