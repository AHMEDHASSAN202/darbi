<?php

namespace Modules\CatalogModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class SpecsResource extends JsonResource
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
            'group_key'      => $this->resource['group_key'],
            'group_name'     => $this->resource['group_name'],
            'specs'          => array_map(function ($spec) {
                                            return [
                                                'name' => translateAttribute($spec['name']),
                                                'image'=> imageUrl($spec['image']),
                                                'key'  => $spec['key']
                                            ];
                                        }, $this->resource['specs'])
        ];
    }
}
