<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\NotificationsModule\Enums;

class NotificationTypes
{
    const BOOKING = 'booking';
    const GENERAL = 'general';

    public static function getTypes()
    {
        $reflectionClass = new \ReflectionClass(static::class);
        return $reflectionClass->getConstants();
    }

    public static function getDefault()
    {
        return self::GENERAL;
    }
}
