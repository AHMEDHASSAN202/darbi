<?php

namespace Modules\BookingModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class BookignResource extends JsonResource
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
