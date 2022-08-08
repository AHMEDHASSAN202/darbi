<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Classes\Validation;

interface ValidationInterface
{
    public function passes() : bool;

    public function error() : string;
}
