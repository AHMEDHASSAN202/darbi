<?php

namespace Modules\AuthModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class FindRoleResource extends JsonResource
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
            'id'            => $this->id,
            'name'          => $this->name,
            'permissions'   => is_string($this->permissions) ? json_decode($this->permissions) : (is_array($this->permissions) ? $this->permissions : []),
            'guard'         => $this->guard
        ];
    }
}
