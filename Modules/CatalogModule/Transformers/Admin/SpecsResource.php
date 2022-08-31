<?php

namespace Modules\CatalogModule\Transformers\Admin;

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
            'id'        => $this->resource['id'],
            'key'       => $this->resource['key'],
            'image'     => imageUrl($this->resource['image'], 'original'),
            'entity_type' => $this->resource['entity_type'],
            'type'      => $this->resource['type']
        ];
    }
}
