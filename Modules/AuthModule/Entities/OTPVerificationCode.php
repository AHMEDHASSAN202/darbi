<?php

namespace Modules\AuthModule\Entities;


use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OTPVerificationCode extends Base
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'otp_verification_codes';

    protected $dates = [
        'expired_at'
    ];


    public function isExpired()
    {
        return now()->greaterThan($this->expired_at);
    }
}
