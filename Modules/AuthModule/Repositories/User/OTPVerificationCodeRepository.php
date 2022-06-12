<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Repositories\User;

use Illuminate\Http\Request;
use Modules\AuthModule\Entities\OTPVerificationCode;

class OTPVerificationCodeRepository
{
    private $model;

    private $expired_at = 45;

    public function __construct(OTPVerificationCode $model)
    {
        $this->model = $model;
    }


    public function findByMobileAndCode($phone, $phoneCode)
    {
        return $this->model->where('phone', $phone)->where('phone_code', $phoneCode)->first();
    }


    public function createNewOTP($phone, $phoneCode)
    {
        return $this->model->create([
            'phone'             => $phone,
            'phone_code'        => $phoneCode,
            'verification_code' => generateOTPCode(),
            'expired_at'        => now()->addSeconds($this->expired_at)->timestamp
        ]);
    }


    public function updateExpiredAtFromOTPObject(OTPVerificationCode $OTPVerificationCode)
    {
        $OTPVerificationCode->expired_at = now()->addSeconds($this->expired_at)->timestamp;
        $OTPVerificationCode->save();
    }


    public function remove($otpId)
    {
        return $this->model->destroy($otpId);
    }
}
