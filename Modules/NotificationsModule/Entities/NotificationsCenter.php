<?php

namespace Modules\NotificationsModule\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class NotificationsCenter extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\NotificationsModule\Database\factories\NotificationsCenterFactory::new();
    }
}
