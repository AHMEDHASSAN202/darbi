<?php

namespace Modules\CatalogModule\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
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
            'id'         => (string)$this->_id,
            'name'       => translateAttribute($this->name),
            'cover_images' => @imagesUrl(convertBsonArrayToNormalArray($this->cover_images), 'thumbnail') ?? [],
            'is_active'  => (boolean)$this->is_active,
            'phone'      => $this->phone,
            'address'    => $this->address,
            'lat'        => $this->lat ? floatval($this->lat) : null,
            'lng'        => $this->lng ? floatval($this->lng) : null,
            'city_id'    => (string)$this->city_id,
        ];
    }
}
