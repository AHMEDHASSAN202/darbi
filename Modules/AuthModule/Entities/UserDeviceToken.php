<?php

namespace Modules\AuthModule\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class UserDeviceToken extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\AuthModule\Database\factories\UserDeviceTokenFactory::new();
    }
}
