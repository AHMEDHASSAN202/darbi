<?php

namespace Modules\AuthModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    public function __construct($resource)
    {
        parent::__construct($resource);
    }

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
            'id'            => $this->_id,
            'phone'         => $this->phone,
            'phone_code'    => $this->phone_code,
            'name'          => $this->name ?? "",
            'identity'      => [
                'frontside_image'   => imageUrl(arrayGet($this->identity, 'frontside_image')),
                'backside_image'    => imageUrl(arrayGet($this->identity, 'backside_image'))
            ],
            'image'           => $image,
            'is_profile_completed' => (!empty($this->name) && !empty(arrayGet($this->identity, 'frontside_image')))
        ];
    }
}
