<?php

namespace Modules\AuthModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\CommonModule\Transformers\CountryResource;
use function asset;

class FindVendorResource extends JsonResource
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
            'id'        => $this->_id,
            'name'      => $this->name,
            'email'     => $this->email,
            'phone'     => $this->phone,
            'phone_code'=> optional($this->country)->calling_code,
            'image'     => imageUrl($this->image),
            'type'      => $this->type,
            'country'   => new CountryResource($this->country),
            'settings'  => $this->settings,
            'currency_code'=> $this->country_currency_code
        ];
    }
}
