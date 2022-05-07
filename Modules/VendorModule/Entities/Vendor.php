<?php

namespace Modules\VendorModule\Entities;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Modules\CommonModule\Traits\RoleHelperTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Vendor extends Authenticatable implements JWTSubject
{
    use HasFactory, SoftDeletes, RoleHelperTrait;

    protected $guarded = [];

    protected $hidden = ['password', 'deleted_at'];

    public $preventActivityLog = ['password'];

    protected $with = ['role'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    //============= Relations ===================\\

    //============= #END# Relations ===================\\
}
