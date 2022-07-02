<?php

namespace Modules\BookingModule\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\BookingModule\Transformers\BookingTraitResource;

class FindBookingResource extends JsonResource
{
    use BookingTraitResource;

    private $defaultImage;

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
            'status_label'  => __($this->status),
            'status'        => $this->status,
            'user_id'       => (string)$this->user_id,
            'user'          => $this->user,
            'vendor_id'     => (string)$this->vendor_id,
            'vendor'        => $this->vendor,
            'entity'        => $this->entity(),
            'start'         => ['month' => $this->start_booking_at->format('m F'), 'time' => $this->start_booking_at->format('H:s A')],
            'end'           => ['month' => $this->end_booking_at->format('m F'), 'time' => $this->end_booking_at->format('H:s A')],
            'extras'        => $this->extras ?? [],
            'pickup_location_address' => $this->pickup_location_address,
            'drop_location_address'   => $this->drop_location_address,
            'payment_method'=> @$this->payment_method['type'] ?? "",
            'note'          => $this->note ?? "",
            'price'         => [
                    'total_price'   => arrayGet($this->price_summary, 'total_price'),
                    'vendor_price'  => arrayGet($this->price_summary, 'vendor_price'),
                    'darbi_price'   => arrayGet($this->price_summary, 'darbi_price')
            ],
            'created_at'    => $this->created_at,
            'expired_at'    => $this->expired_at,
            'invoice_number' => $this->invoice_number,
        ];
    }


    private function entity()
    {
        return [
            'id'        => (string)$this->entity_id,
            'entity_type' => $this->entity_type,
            'name'      => $this->getName(),
            'price'     => $this->entity_details['price'],
            'price_unit' => $this->entity_details['price_unit'],
            'images'        => @$this->entity_details['images'][0],
            'model_id'      => (string)$this->entity_details['model_id'],
            'model_name'    => translateAttribute($this->entity_details['model_name']),
            'brand_id'      => (string)$this->entity_details['brand_id'],
            'brand_name'    => translateAttribute($this->entity_details['brand_name'])
        ];
    }
}
