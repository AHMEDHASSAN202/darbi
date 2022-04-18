<?php

namespace Modules\AdminModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\CommonModule\Transformers\PaginateResource;

class AdminResource extends JsonResource
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
            'email'         => $this->email,
            'role'          => new RoleResource($this->role)
        ];
    }
}
