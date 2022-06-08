<?php

namespace Modules\AuthModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    private $defaultImage;

    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->defaultImage = 'https://via.placeholder.com/250x250.png';
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->_id,
            'phone'         => $this->phone,
            'phone_code'    => $this->phone_code,
            'name'          => $this->name ?? "",
            'identity'      => [
                'frontside_image'   => imageUrl(@$this->identity['frontside_image']),
                'backside_image'    => imageUrl(@$this->identity['backside_image'])
            ],
            'image'           => $this->defaultImage,
            'is_profile_completed' => (!empty($this->name) && !empty(@$this->identity['frontside_image']) && !empty(@$this->identity['backside_image']))
        ];
    }
}
