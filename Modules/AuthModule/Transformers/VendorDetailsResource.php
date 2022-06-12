<?php

namespace Modules\AuthModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use function asset;

class VendorDetailsResource extends JsonResource
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
            'email'     => $this->email,
            'phone'     => $this->phone,
            'image'     => imageUrl($this->image, '', '300x300'),
            'type'      => $this->type,
            'settings'  => $this->settings
        ];
    }
}
