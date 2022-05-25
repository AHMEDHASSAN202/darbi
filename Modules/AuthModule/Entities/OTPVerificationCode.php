<?php

namespace Modules\AuthModule\Entities;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class OTPVerificationCode extends Model
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
