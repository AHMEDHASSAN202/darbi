<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Facades\OTP;

interface OTPInterface
{
    public function send($phone, $phoneCode, $otp);
}
