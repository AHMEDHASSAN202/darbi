<?php

namespace Modules\UserModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name'      => $this->name,
            'email'     => $this->email,
            'phone'     => $this->phone,
            'image'     => $this->image ? asset($this->image) : null,
            'city'      => $this->city,
            'country'   => $this->country
        ];
    }
}
