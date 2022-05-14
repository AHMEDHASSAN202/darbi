<?php

namespace Modules\VendorModule\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['start_at', 'end_at'];

    protected static function newFactory()
    {
        return \Modules\VendorModule\Database\factories\SubscriptionFactory::new();
    }
}
