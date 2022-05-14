<?php

namespace Modules\CommonModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name'          => $this->name,
            'code'          => $this->code,
            'iso3'          => $this->iso3,
            'capital'       => $this->capital,
            'calling_code'  => $this->calling_code,
            'currency_code' => $this->currency_code,
            'currency'      => $this->currency
        ];
    }
}
