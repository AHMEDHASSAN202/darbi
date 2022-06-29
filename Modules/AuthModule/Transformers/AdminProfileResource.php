<?php

namespace Modules\AuthModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminProfileResource extends JsonResource
{
    private $defualtImage;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $images = getAvatarTestImages();

        $this->defualtImage = $images[mt_rand(0, count($images)-1)];
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $response = [
            'id'        => $this->_id,
            'name'      => $this->name,
            'email'     => $this->email,
            'image'     => imageUrl($this->image ?? $this->defualtImage),
            'role'      => new FindRoleResource($this->role),
            'type'      => $this->type
        ];


        if ($this->isVendor()) {
            $response['vendor'] = new VendorResource($this->vendor);
        }

        return $response;
    }
}
