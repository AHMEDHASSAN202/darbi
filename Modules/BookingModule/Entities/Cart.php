<?php

namespace Modules\BookingModule\Entities;

use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Base
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\BookingModule\Database\factories\CartFactory::new();
    }
}
