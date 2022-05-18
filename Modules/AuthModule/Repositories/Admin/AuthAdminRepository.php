<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Repositories\Admin;

use Modules\AuthModule\Entities\Admin;

class AuthAdminRepository
{
    public function find($email)
    {
        return Admin::where('email', $email)->first();
    }
}
