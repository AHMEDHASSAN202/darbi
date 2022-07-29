<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Classes\Validation;

use Carbon\Carbon;

class DayValidation implements ValidationInterface
{
    private $entity;
    private $request;

    public function __construct($entity, $request)
    {
        $this->entity = $entity;
        $this->request = $request;
    }

    public function passes(): bool
    {
        $startAt = Carbon::parse($this->request->start_at);
        $endAy = Carbon::parse($this->request->end_at);

        return $startAt->diffInDays($endAy) >= 1;
    }

    public function error(): string
    {
        return __('The difference between the start date and the end date should be greater than a day');
    }
}
