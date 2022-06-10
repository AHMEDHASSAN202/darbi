<?php

namespace Modules\BookingModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use Modules\CatalogModule\Transformers\CarResource;
use Modules\CatalogModule\Transformers\YachtResource;

class BookingDetailsResource extends JsonResource
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
            'entity'        => $this->entity(),
            'start'         => ['month' => $this->start_booking_at->format('m F'), 'time' => $this->start_booking_at->format('H:s A')],
            'end'           => ['month' => $this->end_booking_at->format('m F'), 'time' => $this->end_booking_at->format('H:s A')],
            'plugins'       => $this->plugins ?? [],
            'pickup_location_address' => $this->pickup_location_address,
            'drop_location_address'   => $this->drop_location_address,
            'payment_method'=> @$this->payment_method['type'] ?? "",
            'note'          => $this->note ?? "",
            'price'         => ['total_price' => @$this->price_summary['total_price']],
            'created_at'    => $this->created_at,
            'expired_at'    => $this->expired_at
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
            'images'        => $this->entity_details['images'],
            'model_id'      => (string)$this->entity_details['model_id'],
            'model_name'    => translateAttribute($this->entity_details['model_name']),
            'brand_id'      => (string)$this->entity_details['brand_id'],
            'brand_name'    => translateAttribute($this->entity_details['brand_name']),
            'country'       => [
                'id'            => @$this->entity_details['country']['_id'],
                'name'          => translateAttribute(@$this->entity_details['country']['name'])
            ],
            'city'       => [
                'id'            => @$this->entity_details['city']['_id'],
                'name'          => translateAttribute(@$this->entity_details['city']['name'])
            ],
        ];
    }
}
