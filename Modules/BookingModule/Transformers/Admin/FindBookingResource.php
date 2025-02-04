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
            'date'          => ['start_at' => $this->start_booking_at, 'end_at' => $this->end_booking_at],
            'extras'        => $this->getExtras($this->extras),
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
            'booking_number' => $this->booking_number,
            'currency_code'  => $this->currency_code
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


    private function getExtras($extras)
    {
        if (empty($extras) || !is_array($extras)) {
            return [];
        }
        return array_map(function ($extra) {
            return [
                'id'            => arrayGet($extra['id'], '$oid'),
                'plugin_id'     => arrayGet($extra, 'plugin_id'),
                'name'          => translateAttribute(arrayGet($extra, 'name')),
                'desc'          => translateAttribute(arrayGet($extra, 'desc')),
                'price'         => arrayGet($extra, 'price'),
                'price_unit'    => arrayGet($extra, 'price_unit', $this->currency_code),
                'entity_type'   => arrayGet($extra, 'entity_type'),
            ];
        }, $extras);
    }
}
