<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\NotificationsModule\Enums;

class NotificationReceiverTypes
{
    const ALL = 'all';
    const SPECIFIED = 'specified';
    const USERS = 'users';
    const VENDORS = 'vendors';

    public static function getTypes()
    {
        $reflectionClass = new \ReflectionClass(static::class);
        return $reflectionClass->getConstants();
    }
}
