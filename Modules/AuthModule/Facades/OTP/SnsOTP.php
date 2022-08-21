<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Facades\OTP;

use Aws\Laravel\AwsFacade;
use Illuminate\Support\Facades\Log;

class SnsOTP implements OTPInterface
{
    public function send($phone, $phoneCode, $otp)
    {
        if (!app()->environment('production')) {
            return;
        }

        try {

            $msgList = config('authmodule.otp_messages');

            $msg = @$msgList[mt_rand(0, (count($msgList)-1))] ?? "Your darbi verification code is: %s";

            $phoneNumber = '+' . $phoneCode . $phone;
            $msg = sprintf($msg, $otp);

            $sms = AwsFacade::createClient('sns');

            $response = $sms->publish([
                'Message' => $msg,
                'PhoneNumber' => $phoneNumber,
                'MessageAttributes' => [
                    'AWS.SNS.SMS.SMSType'  => [
                        'DataType'    => 'String',
                        'StringValue' => 'Transactional',
                    ]
                ],
            ]);

            $metaData = $response->get('@metadata');

            if (!$metaData || arrayGet($metaData, 'statusCode') !== 200) {
                Log::info('OTP AWS SNS response error:', $response);
            }

        }catch (\Exception $exception) {
            Log::error('OTP Msegat exception: ' . $exception->getMessage());
        }
    }
}
