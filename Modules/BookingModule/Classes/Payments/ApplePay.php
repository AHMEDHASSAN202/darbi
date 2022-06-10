<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Classes\Payments;

class ApplePay implements PaymentInterface
{
    public function successTransaction() : bool
    {
        return true;
    }

    public function storeData() : array
    {
        return [];
    }
}
