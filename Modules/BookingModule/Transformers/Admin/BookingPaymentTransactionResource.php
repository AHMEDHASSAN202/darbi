<?php

namespace Modules\BookingModule\Transformers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingPaymentTransactionResource extends JsonResource
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
            'booking_id'    => (string)$this->booking_id,
            'booking_number' => (string)$this->booking_number,
            'entity_id'     => (string)$this->entity_id,
            'name'          => translateAttribute($this->name),
            'amount'        => $this->amount,
            'req'           => $this->req,
            'res'           => $this->res,
            'status'        => $this->status,
            'payment_method'=> $this->payment_method,
            'created_at'    => $this->created_at,
            'price'         => [
                'total_price'   => arrayGet($this->price_summary, 'total_price'),
                'vendor_price'  => arrayGet($this->price_summary, 'vendor_price'),
                'darbi_price'   => arrayGet($this->price_summary, 'darbi_price')
            ],
            'currency_code' => $this->currency_code
        ];
    }
}
