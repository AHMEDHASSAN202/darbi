<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Classes\Payments;

class Cash implements PaymentInterface
{
    private $data;

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function successTransaction() : bool
    {
        return true;
    }

    public function storeData() : array
    {
        return [];
    }
}
