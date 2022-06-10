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

    public function __construct($paymentMethod, $data = [])
    {
        if (!in_array($paymentMethod, array_keys($this->paymentMethods))) {
            Log::error('payment method not exists : ' . $paymentMethod);
            abort(404);
        }

        return new $this->paymentMethods[$paymentMethod]($data);
    }
}
