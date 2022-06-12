<?php

namespace Modules\AuthModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminProfileResource extends JsonResource
{
    private $defaultImage = 'https://uce338230fe998d40bc5230b1c0d.dl.dropboxusercontent.com/cd/0/inline/Bm9Qu3BSE_M50pCQYqBvV1kd5-YBnPE0PL6ZqHZuSNE2SyEi7YERQbf5bmm_ont_VlBw7_EAieSFLsOhEBiHtes66srrv2AkhIbRlciTg11hgXPbhPkFpxOHMtRq_yPRwagM9mu0xnTEIGuQ_N_yHJZ2UauUDwAKDJkIsqrKldyhRw/file';

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
            'image'     => imageUrl($this->image ?? $this->defaultImage, '', '300x300'),
            'role'      => new RoleResource($this->role),
            'vendor'    => new VendorResource($this->vendor),
            'type'      => $this->type
        ];
    }
}
