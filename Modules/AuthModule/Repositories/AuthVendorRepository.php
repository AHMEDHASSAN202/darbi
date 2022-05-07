<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Repositories;


use Modules\VendorModule\Entities\Vendor;

class AuthVendorRepository
{
    public function find($email)
    {
        return Vendor::where('email', $email)->first();
    }
}
