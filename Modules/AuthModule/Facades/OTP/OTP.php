<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Facades\OTP;

use Illuminate\Support\Facades\Log;

class OTP implements OTPInterface
{
    public function send($phone, $phoneCode, $otp)
    {
        try {

        }catch (\Exception $exception) {
            Log::error('Signin OTP exception: ' . $exception->getMessage());
        }
    }
}
