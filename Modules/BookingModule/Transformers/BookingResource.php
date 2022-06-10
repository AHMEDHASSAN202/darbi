<?php

namespace Modules\BookingModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

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
            'date_label'    => $this->getDateLabel(),
            'status_label'  => __($this->status),
            'status'        => $this->status,
            'type'          => $this->entity_type,
            'image'         => imageUrl(@$this->entity_details['images'][0] ?? $this->defaultImage)
        ];
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
}
