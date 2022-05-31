<?php

namespace Modules\CatalogModule\Entities;

use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Base
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['start_at', 'end_at'];

    protected static function newFactory()
    {
        return \Modules\CatalogModule\Database\factories\SubscriptionFactory::new();
    }
}
