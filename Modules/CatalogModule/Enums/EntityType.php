<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Enums;

class EntityType
{
    const CAR = 'car';
    const YACHT = 'yacht';

    public static function getTypes()
    {
        $reflectionClass = new \ReflectionClass(static::class);
        return $reflectionClass->getConstants();
    }
}
