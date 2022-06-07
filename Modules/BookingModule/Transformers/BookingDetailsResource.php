<?php

namespace Modules\BookingModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use Modules\CatalogModule\Transformers\CarResource;
use Modules\CatalogModule\Transformers\YachtResource;

class BookingDetailsResource extends JsonResource
{
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
            'status_label'  => $this->getState(),
            'status'        => $this->status,
            'entity'        => $this->getEntity(),
            'start'         => ['month' => $this->start_booking_at->format('m F'), 'time' => $this->start_booking_at->format('H:s A')],
            'end'           => ['month' => $this->end_booking_at->format('m F'), 'time' => $this->end_booking_at->format('H:s A')],
            'plugins'       => $this->pluginsTransform(),
            'location'      => $this->pickup_location_address,
            'location_label'=> $this->getPickupLocationAddressLabel(),
            'payment_method'=> @$this->payment_method['type'] ?? "",
            'image'         => imageUrl(@$this->entity_details['images'][0] ?? $this->defaultImage),
            'created_at'    => $this->created_at
        ];
    }

    private function getEntity()
    {
        $entity = $this->entity;

        if (!$entity) {
            Log::error('entity not found in booking', ['bookingId' => $this->_id]);
            return;
        }

        if ($entity->isCarType()) {
            return new CarResource($this->entity);
        }else {
            return new YachtResource($this->entity);
        }
    }

    private function getState()
    {
        return __($this->status);
    }

    private function pluginsTransform() : array
    {
        $plugins = @$this->entity_details['plugins'] ?? [];

        if (empty($plugins) || !is_array($plugins)) return [];

        return array_map(function ($plugin) {
            return ['name' => translateAttribute($plugin['name']), 'price' => number_format($plugin['price_per_day'], 2)];
        }, $plugins);
    }

    private function getPickupLocationAddressLabel() : string
    {
        if (!$this->pickup_location_address || !is_array($this->pickup_location_address)) return '';

        return $this->pickup_location_address['state'] . ' ' . $this->pickup_location_address['city'] . ' ' . $this->pickup_location_address['country'];
    }
}
