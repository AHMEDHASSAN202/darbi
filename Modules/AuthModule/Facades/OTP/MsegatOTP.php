<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Facades\OTP;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MsegatOTP implements OTPInterface
{
    public function send($phone, $phoneCode, $otp)
    {
        if (config('authmodule.used_otp_provider') === false) {
            return;
        }

        try {

            $response = Http::acceptJson()->retry(2, 100)->post('https://www.msegat.com/gw/sendsms.php', [
                'userName'          => env('MSEGAT_USERNAME'),
                'apiKey'            => env('MSEGAT_API_KEY'),
                'numbers'           => $phoneCode . $phone,
                'userSender'        => env('MSEGAT_SENDER'),
                'msg'               => sprintf(config('authmodule.otp_message_text', 'Verification Code: %s'), $otp)
            ])->json();

            if ($response['code'] != '1' && $response['code'] != 'M0000') {
                Log::info('OTP Msegat response error:', $response);
            }

        }catch (\Exception $exception) {
            Log::error('OTP Msegat exception: ' . $exception->getMessage());
        }
    }
}
