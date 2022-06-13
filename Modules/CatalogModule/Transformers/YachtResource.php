<?php

namespace Modules\CatalogModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'passengers'    => $this->passengers()
        ];
    }


    private function passengers()
    {
        $passengers = @$this->model->specs['passengers'];
        if (!$passengers) {
            return null;
        }
        return [
            'minimum'       => $passengers['value']['minimum'],
            'maximum'       => $passengers['value']['maximum']
        ];
    }
}
