<?php

namespace Modules\CatalogModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\CatalogModule\Transformers\Admin\BranchResource;

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
            'id'            => (string)$this->_id,
            'images'        => $this->getImagesFullPath(),
            'name'          => $this->name,
            'brand_name'    => optional($this->brand)->name,
            'brand_id'      => (string)optional($this->brand)->id,
            'model_name'    => optional($this->model)->name,
            'model_id'      => (string)optional($this->model)->id,
            'price'         => $this->price,
            'price_unit'    => $this->price_unit,
            'price_label'   => generatePriceLabelFromPrice($this->price, $this->price_unit),
            'extras'        => ExtraResource::collection(convertBsonArrayToCollection($this->attachPluginToExtra($this->extras, $this->plugins))),
            'state'         => $this->state,
            'specs'         => SpecsResource::collection($this->model->specs),
            'country'       => $this->country,
            'vendor_id'     => (string)$this->vendor_id,
            'entity_type'   => $this->type,
            'branch_id'     => (string)$this->branch_id,
            'branch'        => new BranchResource($this->branch)
        ];
    }
}
