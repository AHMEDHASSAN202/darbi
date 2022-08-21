<?php

namespace Modules\CatalogModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class YachtResource extends JsonResource
{
    use EntityTrait;

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
            'name'          => translateAttribute($this->name),
            'image'         => $this->getMainImage(),
            'price'         => $this->price,
            'price_unit'    => $this->price_unit,
            'passengers'    => $this->passengers(),
            'currency_code' => optional($this->vendor)->country_currency_code
        ];
    }


    private function passengers()
    {
        $passengers =  Arr::first(
            optional($this->model)->specs ?? $this->attributes ?? [],
            function ($spec) { return $spec['key'] == 'passengers'; }
        );

        if (!$passengers) {
            return null;
        }

        return arrayGet($passengers, 'value');
    }
}
