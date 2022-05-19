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
            'type'          => optional($this->entity)->type,
            'image'         => $this->getImage(),
        ];
    }

    private function getName()
    {
        $entity = $this->entity;

        if (!$entity) {
            Log::error('entity not found in booking', ['bookingId' => $this->_id]);
            return;
        }

        if ($entity->isCarType()) {
            return translateAttribute(optional($entity->brand)->name) . ' ' . translateAttribute(optional($entity->model)->name);
        }else {
            return translateAttribute($entity->name);
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

    public function getImage()
    {
        $entityMainImage = @$this->entity->images[0];

        if (!$entityMainImage) {
            $modelImages = optional($this->entity->model)->images;
            if ($modelImages && is_array($modelImages)) {
                $entityMainImage = $modelImages[0];
            }
        }

        return imageUrl($entityMainImage ?? $this->defaultImage);
    }
}
