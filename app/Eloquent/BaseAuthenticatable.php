<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace App\Eloquent;

use Jenssegers\Mongodb\Auth\User as Authenticatable;

class BaseAuthenticatable extends Authenticatable
{
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
}
