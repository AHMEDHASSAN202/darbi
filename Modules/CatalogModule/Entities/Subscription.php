<?php

namespace Modules\CatalogModule\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['start_at', 'end_at'];

    protected static function newFactory()
    {
        return \Modules\CatalogModule\Database\factories\SubscriptionFactory::new();
    }
}
