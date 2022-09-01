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
        if (isset($this->resource['image']) && is_array($this->resource['image'])) {
            $key = arrayGet($this->resource['image'], 'key');
            $value = arrayGet($this->resource, 'value');
            $image = arrayGet($this->resource['image'], 'full_url');
        }else {
            $key = arrayGet($this->resource, 'key');
            $value = arrayGet($this->resource, 'value');
            $image = arrayGet($this->resource, 'image');
        }

        return [
            'key'       => $key,
            'value'     => $value,
            'image'     => $image
        ];
    }
}
