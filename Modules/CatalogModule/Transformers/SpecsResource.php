<?php

namespace Modules\CatalogModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class SpecsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'key'       => $this->resource['image']['key'],
            'value'     => $this->resource['value'],
            'image'     => $this->resource['image']['full_url']
        ];
    }
}
