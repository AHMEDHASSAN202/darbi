<?php

namespace Modules\AuthModule\Entities;

use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDeviceToken extends Base
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\AuthModule\Database\factories\UserDeviceTokenFactory::new();
    }
}
