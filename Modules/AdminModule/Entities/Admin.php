<?php

namespace Modules\AdminModule\Entities;

use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Modules\CommonModule\Traits\AddIdModelPropertyTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends Authenticatable implements JWTSubject
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $hidden = ['password', 'deleted_at'];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    //============= Relations ===================\\
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    //============= #END# Relations ===================\\
}
