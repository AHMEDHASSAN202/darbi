<?php

namespace Modules\AuthModule\Entities;

use App\Eloquent\BaseAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Modules\AuthModule\Database\factories\AdminFactory;
use Modules\AuthModule\Traits\RoleHelperTrait;
use Modules\CatalogModule\Entities\Vendor;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends BaseAuthenticatable implements JWTSubject
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

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

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
