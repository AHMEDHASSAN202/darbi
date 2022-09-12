<?php

namespace Modules\AuthModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;


class VendorResource extends JsonResource
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
            'id'        => $this->_id,
            'name'      => translateAttribute($this->name),
            'image'     => imageUrl($this->image, 'thumbnail'),
            'type'      => $this->type,
            'currency_code' => $this->country_currency_code
        ];
    }
}
