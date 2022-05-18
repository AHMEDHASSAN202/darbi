<?php

namespace Modules\CatalogModule\Entities;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Modules\CatalogModule\Database\factories\VendorFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use function request;

class Vendor extends Authenticatable implements JWTSubject
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $hidden = ['password', 'deleted_at'];

    public $preventActivityLog = ['password'];


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
        return VendorFactory::new();
    }

    //============= Relations ===================\\

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    //============= #END# Relations ===================\\

    //============= scopes ==============\\
    public function scopeAdminSearch($query)
    {
        if ($q = request()->q) {
            return $query->where('name', 'LIKE', '%' . $q .'%');
        }
    }
    //============= #END# scopes ==============\\
}
