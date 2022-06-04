<?php

namespace Modules\CatalogModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            'id'            => $this->_id,
            'images'        => $this->getImagesFullPath(),
            'name'          => $this->name,
            'brand_name'    => optional($this->brand)->name,
            'brand_id'      => optional($this->brand)->id,
            'model_name'    => optional($this->model)->name,
            'model_id'      => optional($this->model)->id,
            'price'         => $this->price,
            'price_unit'    => $this->price_unit,
            'price_label'   => generatePriceLabelFromPrice($this->price, $this->price_unit),
            'plugins'       => PluginResource::collection($this->plugins),
            'state'         => $this->state,
            'specs'         => SpecsResource::collection($this->model->addons),
            'country'       => $this->country,
            'city'          => $this->city
        ];
    }
}
