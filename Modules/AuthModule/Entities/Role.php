<?php

namespace Modules\AuthModule\Entities;

use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Role extends Base
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    //============= relations ==============\\
    public function admins()
    {
        return $this->hasMany(Admin::class, '_id');
    }
    //============= #END# relations ==============\\

    //============= scopes ==============\\
    public function scopeAdminSearch($query, Request $request)
    {
        if ($q = $request->get('q')) {
            return $query->where('name', 'LIKE', '%' . $q .'%');
        }
    }

    public function scopeAdminFilter($query, Request $request)
    {
        if ($guard = $request->get('guard')) {
            $query->where('guard', $guard);
        }
        if ($type = $request->get('type')) {
            //vendor_api || admin_api
            $query->where('guard', $type . '_api');
        }
        if (!$request->get('with-system-roles')) {
            $query->whereNotIn('key', config('authmodule.system_roles', []));
        }
    }
    //============= #END# scopes ==============\\
}
