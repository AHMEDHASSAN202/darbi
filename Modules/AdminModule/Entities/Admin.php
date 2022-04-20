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
    public function role()
    {
        return $this->belongsTo(Role::class);
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

    public function hasPermissions($permission)
    {
        $permissions = is_array($permission) ? $permission : [$permission];
        $rolePermissions = optional($this->role)->permissions;
        $myPermissions = is_array($rolePermissions) ? $rolePermissions : (json_decode($rolePermissions) ?? []);
        foreach ($permissions as $per) {
            if (!in_array($per, $myPermissions)) {
                return false;
            }
        }
        return true;
    }
}
