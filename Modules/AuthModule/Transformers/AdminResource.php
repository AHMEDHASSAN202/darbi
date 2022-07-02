<?php

namespace Modules\AuthModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

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
        $images = getAvatarTestImages();

        $defaultImage = $images[mt_rand(0, count($images)-1)];

        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'role'          => new RoleResource($this->role),
            'type'          => $this->type,
            'vendor'        => new VendorResource($this->vendor),
            'image'         => imageUrl($this->image ?? $defaultImage)
        ];
    }
}
