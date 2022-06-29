<?php

namespace Modules\BookingModule\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\BookingModule\Transformers\BookingTraitResource;

class BookingResource extends JsonResource
{
    use BookingTraitResource;

    private $defaultImage = '';

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
            'name'          => $this->getName(),
            'user'          => $this->user,
            'vendor_name'   => translateAttribute($this->vendor),
            'date'          => ['start_at' => $this->start_booking_at, 'end_at' => $this->end_booking_at],
            'status_label'  => __($this->status),
            'status'        => $this->status,
            'type'          => $this->entity_type,
            'image'         => imageUrl(@$this->entity_details['images'][0] ?? $this->defaultImage)
        ];
    }
}
