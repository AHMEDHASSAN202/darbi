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

        $lastBooking = $this->lastBooking;
        if ($lastBooking) {
            $lastBooking =  [
                'id'            => objectGet($this->lastBooking, '_id'),
                'entity_name'   => translateAttribute(arrayGet(objectGet($this->lastBooking, 'entity_details'), 'name')),
                'vendor_name'   => translateAttribute(arrayGet(objectGet($this->lastBooking, 'vendor'), 'name')),
                'price'         => [
                    'total_price'    => arrayGet(objectGet($this->lastBooking, 'price_summary'), 'total_price'),
                    'vendor_price'   => arrayGet(objectGet($this->lastBooking, 'price_summary'), 'vendor_price'),
                    'darbi_price'    => arrayGet(objectGet($this->lastBooking, 'price_summary'), 'darbi_price'),
                ]
            ];
        }

        return [
            'id'        => $this->_id,
            'name'      => $this->name,
            'phone_code'=> $this->phone_code,
            'phone'     => $this->phone,
            'image'     => $image,
            'is_active' => (boolean)$this->is_active,
            'is_profile_completed' => (!empty($this->name) && !empty(@$this->identity['frontside_image']) && !empty(@$this->identity['backside_image'])),
            'last_booking'  => $lastBooking
        ];
    }
}
