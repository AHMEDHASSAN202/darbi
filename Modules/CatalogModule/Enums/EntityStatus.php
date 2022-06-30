<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Enums;

class EntityStatus
{
    const FREE = 'free';
    const RESERVED = 'reserved';
    const PENDING = 'pending';

    public static function getTypes()
    {
        $reflectionClass = new \ReflectionClass(static::class);
        return $reflectionClass->getConstants();
    }
}
