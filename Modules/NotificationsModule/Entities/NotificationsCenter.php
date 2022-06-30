<?php

namespace Modules\NotificationsModule\Entities;

use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotificationsCenter extends Base
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\NotificationsModule\Database\factories\NotificationsCenterFactory::new();
    }
}
