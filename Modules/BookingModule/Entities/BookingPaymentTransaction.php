<?php

namespace Modules\BookingModule\Entities;

use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingPaymentTransaction extends Base
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\BookingModule\Database\factories\BookingPaymentTransactionFactory::new();
    }
}
