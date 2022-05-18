<?php

namespace Modules\AuthModule\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Modules\AuthModule\Database\factories\AdminFactory;
use Modules\AuthModule\Traits\RoleHelperTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends Authenticatable implements JWTSubject
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

    protected static function newFactory()
    {
        return AdminFactory::new();
    }

    //============= Relations ===================\\

    //============= #END# Relations ===================\\

    //============= scopes ==============\\
    public function scopeSearch($query, Request $request)
    {
        if ($q = $request->get('q')) {
            return $query->where('name', 'LIKE', '%' . $q .'%');
        }
    }
    //============= #END# scopes ==============\\
}
