<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace App\Eloquent;

use Jenssegers\Mongodb\Eloquent\Model;

abstract class Base extends Model
{
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
}
