<?php

namespace Modules\BookingModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class BookingResource extends JsonResource
{
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
            'date_label'    => $this->getDateLabel(),
            'status_label'  => $this->getState(),
            'status'        => $this->status,
            'type'          => $this->entity_type,
            'image'         => imageUrl(@$this->entity_details->images[0] ?? $this->defaultImage),
            'plugins'       => $this->entity_details->plugins
        ];
    }

    private function getName()
    {
        if ($this->entity_type == 'car') {
            return translateAttribute(optional($this->entity_details)->brand_name) . ' ' . translateAttribute(optional($this->entity_details)->model_name);
        }else {
            return translateAttribute($this->entity_details->name);
        }
    }

    private function getDateLabel()
    {
        $startMonth = $this->start_booking_at->format('m');
        $startMonthName = $this->start_booking_at->format('F');
        $endMonth = $this->end_booking_at->format('m');
        $endMonthName = $this->end_booking_at->format('F');

        if ($startMonth == $endMonth) {
            return $startMonth . ' - ' . $endMonth . ' ' . $startMonthName . ' ' . $this->end_booking_at->format('Y');
        }

        return $startMonth . ' ' . $startMonthName . ' - ' . $endMonth . ' ' . $endMonthName . ' ' . $this->end_booking_at->format('Y');
    }

    public function getState()
    {
        return __($this->status);
    }
}
