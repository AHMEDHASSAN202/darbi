<?php

namespace Modules\CatalogModule\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\CommonModule\Transformers\CityResource;

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
            'name'       => $request->has('for-edit') ? $this->name : translateAttribute($this->name),
            'cover_images' => imagesUrl(convertBsonArrayToNormalArray($this->cover_images)),
            'is_active'  => (boolean)$this->is_active,
            'phone'      => $this->phone,
            'address'    => $this->address,
            'lat'        => $this->lat,
            'lng'        => $this->lng,
            'city_id'    => (string)$this->city_id,
            'city'       => new CityResource($this->city),
//            'region_id'  => (string)$this->region_id,
        ];
    }
}
