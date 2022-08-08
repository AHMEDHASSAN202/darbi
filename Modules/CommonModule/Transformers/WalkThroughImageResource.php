<?php

namespace Modules\CommonModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class WalkThroughImageResource extends JsonResource
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
            'title'             => translateAttribute($this['title']),
            'image'             => imageUrl($this['image'], 'original'),
            'desc'              => translateAttribute($this['desc']),
        ];
    }
}
