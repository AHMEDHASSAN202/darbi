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

            $msgList = config('authmodule.otp_messages');

            $msg = @$msgList[mt_rand(0, (count($msgList)-1))] ?? "Your darbi verification code is: %s";
            $msg .= str_repeat('.', mt_rand(0, 5));

            $response = Http::acceptJson()->retry(2, 100)->post('https://www.msegat.com/gw/sendsms.php', [
                'userName'          => env('MSEGAT_USERNAME'),
                'apiKey'            => env('MSEGAT_API_KEY'),
                'numbers'           => $phoneCode . $phone,
                'userSender'        => env('MSEGAT_SENDER'),
                'msg'               => sprintf($msg, $otp),
                'msgEncoding'       => 'UTF8'
            ])->json();

            Log::info(sprintf($msg, $otp));

            if ($response['code'] != '1' && $response['code'] != 'M0000') {
                Log::info('OTP Msegat response error:', $response);
            }

        }catch (\Exception $exception) {
            Log::error('OTP Msegat exception: ' . $exception->getMessage());
        }
    }
}
