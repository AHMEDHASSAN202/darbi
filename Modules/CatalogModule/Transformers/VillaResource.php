<?php

namespace Modules\CatalogModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class VillaResource extends JsonResource
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
            'guests'        => $this->guests(),
            'currency_code' => optional($this->vendor)->country_currency_code
        ];
    }



    private function guests()
    {
        $guests =  Arr::first(
            $this->attributes ?? [],
            function ($spec) { return $spec['key'] == 'guests'; }
        );

        if (!$guests) {
            return null;
        }

        return arrayGet($guests, 'value');
    }
}
