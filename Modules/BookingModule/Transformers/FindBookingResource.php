<?php

namespace Modules\BookingModule\Transformers;

use App\Proxy\Proxy;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\BookingModule\Proxy\BookingProxy;

class FindBookingResource extends JsonResource
{
    use BookingTraitResource;

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
            'rejected_reason' => $this->rejected_reason,
            'entity'        => $this->entity(),
            'start'         => $this->start_booking_at,
            'end'           => $this->end_booking_at,
            'start_trip_at' => $this->start_trip_at,
            'end_trip_at'   => $this->end_trip_at,
            'extras'        => $this->extrasResource(),
            'pickup_location_address' => !empty($this->pickup_location_address) ? $this->pickup_location_address : null,
            'drop_location_address'   => !empty($this->drop_location_address) ? $this->drop_location_address : null,
            'payment_method'=> @$this->payment_method['type'] ?? "",
            'note'          => $this->note ?? "",
            'price'         => ['total_price' => @$this->price_summary['total_price']],
            'created_at'    => $this->created_at,
            'expired_at'    => $this->expired_at,
            'vendor'        => $this->getVendor(),
            'booking_number' => $this->booking_number,
            'currency_code' => $this->currency_code
        ];
    }


    private function entity()
    {
        return [
            'id'            => (string)$this->entity_id,
            'entity_type'   => $this->entity_type,
            'name'          => $this->getName(),
            'price'         => $this->entity_details['price'],
            'price_unit'    => $this->entity_details['price_unit'],
            'images'        => @$this->entity_details['images'][0],
            'model_id'      => (string)$this->entity_details['model_id'],
            'model_name'    => translateAttribute($this->entity_details['model_name']),
            'brand_id'      => (string)$this->entity_details['brand_id'],
            'brand_name'    => translateAttribute($this->entity_details['brand_name']),
        ];
    }


    private function extrasResource()
    {
        $extras = $this->extras;

        if (empty($extras) || !is_array($extras)) {
            return [];
        }

        return array_map(function ($extra) {
            return [
                'id'         => (string)$extra['id']['$oid'],
                'plugin_id'  => (string)$extra['plugin_id'],
                'name'       => translateAttribute($extra['name']),
                'desc'       => translateAttribute($extra['desc']),
                'price'      => $extra['price'],
                'price_unit' => $this->entity_details['price_unit']
            ];
        }, $extras);
    }


    private function getVendor()
    {
        $vendor = $this->vendor;
        return [
            'id'     => arrayGet($vendor, 'id'),
            'type'   => arrayGet($vendor, 'type'),
            'phone'  => arrayGet($vendor, 'phone'),
            'lat'    => arrayGet($vendor, 'lat'),
            'lng'    => arrayGet($vendor, 'lng'),
            'currency_code' => arrayGet($vendor, 'country_currency_code')
        ];
    }
}
