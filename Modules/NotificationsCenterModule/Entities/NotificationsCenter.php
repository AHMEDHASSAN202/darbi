<?php

namespace Modules\NotificationsCenterModule\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class NotificationsCenter extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\NotificationsCenterModule\Database\factories\NotificationsCenterFactory::new();
    }
}
