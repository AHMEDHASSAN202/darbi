<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Transformers;

trait HelperRegionResource
{
    private function getLocationPoints()
    {
        $coordinates = arrayGet($this->location, 'coordinates');

        if (empty($coordinates)) return [];

        $points = [];

        foreach ($coordinates[0] as $coordinate) {
            $points[] = ['lat' => arrayGet($coordinate, 1), 'lng' => arrayGet($coordinate, 0)];
        }

        return $points;
    }
}
