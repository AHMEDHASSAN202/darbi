<?php

namespace Modules\YachtModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class YachtResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
