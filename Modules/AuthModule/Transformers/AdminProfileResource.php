<?php

namespace Modules\AuthModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminProfileResource extends JsonResource
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
            'role'      => new RoleResource($this->role),
            'vendor'    => new VendorResource($this->vendor)
        ];
    }
}
