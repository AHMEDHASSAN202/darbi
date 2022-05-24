<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Facades;

use Illuminate\Support\Facades\Facade;

class OTPFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'OTP';
    }
}
