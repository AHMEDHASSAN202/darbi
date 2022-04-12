<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Repositories;

use Modules\AdminModule\Entities\Admin;

class AuthAdminRepository
{
    public function find($email)
    {
        return Admin::where('email', $email)->first();
    }
}
