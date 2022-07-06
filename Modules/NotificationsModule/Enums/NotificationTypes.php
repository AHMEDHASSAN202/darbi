<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\NotificationsModule\Enums;

class NotificationTypes
{
    const BOOKING = 'booking';
    const OFFER = 'offer';
    const GENERAL = 'general';

    public static function getTypes()
    {
        $reflectionClass = new \ReflectionClass(static::class);
        return $reflectionClass->getConstants();
    }
}
