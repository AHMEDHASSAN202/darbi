<?php

namespace Modules\AuthModule\Transformers;

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
        $avatars = getAvatarTestImages();
        $image = $avatars[mt_rand(0, (count($avatars) - 1))];

        return [
            'id'        => $this->_id,
            'name'      => $this->name,
            'phone_code'=> $this->phone_code,
            'phone'     => $this->phone,
            'image'     => $image,
            'is_active' => (boolean)$this->is_active,
            'is_profile_completed' => (!empty($this->name) && !empty(@$this->identity['frontside_image']) && !empty(@$this->identity['backside_image']))
        ];
    }
}
