<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Classes\Payments;

use Illuminate\Support\Facades\Log;

class Payment
{
    private $paymentMethods = [
        'cash'          => Cash::class,
        'apple_pay'     => ApplePay::class,
    ];

    private $paymentObject;


    public function __construct($paymentMethod, $data = [])
    {
        if (!in_array($paymentMethod, array_keys($this->paymentMethods))) {
            Log::error('payment method not exists : ' . $paymentMethod);
            abort(404);
        }

        $this->paymentObject = new $this->paymentMethods[$paymentMethod]($data);
    }


    public function getInstance()
    {
        return $this->paymentObject;
    }


    public function __call(string $name, array $arguments)
    {
        return $this->paymentObject->{$name}(...$arguments);
    }
}
