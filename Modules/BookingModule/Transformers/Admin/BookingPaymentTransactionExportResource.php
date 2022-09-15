<?php

namespace Modules\BookingModule\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingPaymentTransactionExportResource extends JsonResource
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
            'name'          => translateAttribute($this->name),
            'amount'        => $this->amount,
            'status'        => $this->status ? 'Success' : 'Failed',
            'payment_method'=> $this->payment_method,
            'created_at'    => $this->created_at,
            'vendor_price'  => arrayGet($this->price_summary, 'vendor_price'),
            'darbi_price'   => arrayGet($this->price_summary, 'darbi_price')
        ];
    }
}
