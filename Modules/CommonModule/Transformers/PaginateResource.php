<?php

namespace Modules\CommonModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PaginateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $resource = $this->resource;
        return [
            'count'             => $resource->count(),
            'currentPage'       => $resource->currentPage(),
            'hasMorePages'      => $resource->hasMorePages(),
            'items'             => $resource->items(),
            'total'             => $resource->total(),
            'lastPage'          => $resource->lastPage(),
            'perPage'           => $resource->perPage()
        ];
    }
}
