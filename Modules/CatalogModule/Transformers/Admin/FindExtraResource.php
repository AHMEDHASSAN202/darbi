<?php

namespace Modules\CatalogModule\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class FindExtraResource extends JsonResource
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
            'id'            => (string)$this->_id,
            'plugin_id'     => (string) $this->plugin_id,
            'name'          => translateAttribute(@(array)$this->plugin->name),
            'desc'          => translateAttribute(@(array)$this->plugin->desc),
            'price'         => $this->price,
            'entity_type'   => @$this->plugin ? optional($this->plugin)->entity_type : '',
            'plugin'        => @$this->plugin ? new PluginResource($this->plugin) : null
        ];
    }

}
