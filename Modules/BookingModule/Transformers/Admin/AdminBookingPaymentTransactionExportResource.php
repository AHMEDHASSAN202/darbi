<?php

namespace Modules\BookingModule\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminBookingPaymentTransactionExportResource extends JsonResource
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
            'vendor_name'   => translateAttribute(optional($this->vendor)->name),
            'name'          => translateAttribute($this->name),
            'amount'        => $this->amount,
            'status'        => $this->status ? 'Success' : 'Failed',
            'payment_method'=> $this->payment_method,
            'created_at'    => optional($this->created_at)->format('Y-m-d H:m')
        ];
    }
}
