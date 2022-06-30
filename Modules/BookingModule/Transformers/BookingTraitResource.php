<?php

namespace Modules\BookingModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

trait BookingTraitResource
{
    private function getName()
    {
        if ($this->entity_type == 'car') {
            return translateAttribute(@$this->entity_details['brand_name']) . ' ' . translateAttribute(@$this->entity_details['model_name']);
        }else {
            return translateAttribute(@$this->entity_details['name']);
        }
    }
}
