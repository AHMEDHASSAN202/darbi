<?php

namespace Modules\AuthModule\Entities;

use App\Eloquent\BaseAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Modules\AuthModule\Database\factories\AdminFactory;
use Modules\AuthModule\Traits\RoleHelperTrait;
use Modules\CatalogModule\Entities\Vendor;
use MongoDB\BSON\ObjectId;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends BaseAuthenticatable implements JWTSubject
{
    use HasFactory, SoftDeletes, RoleHelperTrait;

    protected $table = 'admins';

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
        return [
            'version'       => config('authmodule.jwt_version'),
        ];
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

    public function scopeFilter($query, Request $request)
    {
        if ($role = $request->get('role')) {
            $query->where('role_id', new ObjectId($role));
        }

        if ($type = $request->get('type')) {
            $query->where('type', $type);
        }

        if ($vendor = $request->get('vendor')) {
            $query->where('vendor_id', new ObjectId($vendor));
        }
    }

    //============= #END# scopes ==============\\

    //================ Helpers ====================\\

    public function isVendor()
    {
        return $this->type === 'vendor';
    }

    public function isAdmin()
    {
        return $this->type === 'admin';
    }

    //==================== #END# Helpers ================\\
}
