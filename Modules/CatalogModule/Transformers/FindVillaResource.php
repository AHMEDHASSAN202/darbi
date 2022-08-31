<?php

namespace Modules\CatalogModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class FindVillaResource extends JsonResource
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
            'built_date'    => $this->built_date ? (int)$this->built_date : null,
            'extras'        => $this->getExtras(),
            'vendor'        => $this->getVendor(),
            'location'      => $this->location,
            'specs'         => $this->getAttributes()
        ];
    }
}
