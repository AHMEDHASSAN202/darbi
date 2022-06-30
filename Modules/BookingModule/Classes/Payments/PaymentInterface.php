<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Classes\Payments;

interface PaymentInterface
{
    public function successTransaction() : bool;

    public function storeData() : array;
}
