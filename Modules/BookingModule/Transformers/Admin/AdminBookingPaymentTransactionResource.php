<?php

namespace Modules\BookingModule\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\CatalogModule\Transformers\Admin\VendorResource;

class AdminBookingPaymentTransactionResource extends JsonResource
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
            'id'            => (string)$this->id,
            'vendor_id'     => (string)$this->vendor_id,
            'vendor_name'   => translateAttribute(optional($this->vendor)->name),
            'booking_id'    => (string)$this->booking_id,
            'entity_id'     => (string)$this->entity_id,
            'name'          => translateAttribute($this->name),
            'amount'        => $this->amount,
            'req'           => $this->req,
            'res'           => $this->res,
            'status'        => $this->status,
            'payment_method'=> $this->payment_method,
            'created_at'    => $this->created_at
        ];
    }
}
