<?php

namespace Modules\CommonModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name'              => translateAttribute($this['name']),
            'desc'              => translateAttribute($this['desc']),
            'image'             => imageUrl($this['image']),
        ];
    }
}
