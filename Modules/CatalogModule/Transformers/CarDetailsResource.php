<?php

namespace Modules\CatalogModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CarDetailsResource extends JsonResource
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
            'plugins'       => $this->getPlugins(),
            'state'         => $this->state,
            'specs'         => SpecsResource::collection($this->model->addons)
        ];
    }
}
