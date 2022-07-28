<?php

namespace Modules\AuthModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use function asset;

class FindUserResource extends JsonResource
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
                ],
                'created_at'    => optional($this->created_at)->format('Y-m-d H:m')
            ];
        }

        return [
            'id'        => $this->_id,
            'name'      => $this->name,
            'phone_code'=> $this->phone_code,
            'phone'     => $this->phone,
            'image'     => $image,
            'is_active' => (boolean)$this->is_active,
            'identity'      => [
                'frontside_image'   => imageUrl(arrayGet($this->identity, 'frontside_image')),
                'backside_image'    => imageUrl(arrayGet($this->identity, 'backside_image'))
            ],
            'is_profile_completed' => (!empty($this->name) && !empty(arrayGet($this->identity, 'frontside_image')) && !empty(arrayGet($this->identity, 'backside_image'))),
            'locations' => SavedPlaceResource::collection($this->savedPlaces),
            'last_booking' => $lastBooking
        ];
    }
}
