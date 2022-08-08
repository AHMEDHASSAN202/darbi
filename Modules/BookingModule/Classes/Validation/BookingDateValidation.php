<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Classes\Validation;

use Illuminate\Http\Request;

class BookingDateValidation
{
    private $entity;
    private $units = [
        'day'  => DayValidation::class,
        'hour' => HourValidation::class
    ];

    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    public function validator(Request $request)
    {
        $entityPriceUnit = arrayGet($this->entity, 'price_unit');

        if (!$entityPriceUnit || !isset($this->units[$entityPriceUnit])) {
            throw new \Exception("Price unit not exists");
        }

        return new $this->units[$entityPriceUnit]($this->entity, $request);
    }
}
