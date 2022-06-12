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

    protected $casts = [
        'permissions'       => 'array'
    ];


    //============= relations ==============\\
    public function admins()
    {
        return $this->hasMany(Admin::class);
    }
    //============= #END# relations ==============\\

    //============= scopes ==============\\
    public function scopeAdminSearch($query, Request $request)
    {
        if ($q = $request->get('q')) {
            return $query->where('name', 'LIKE', '%' . $q .'%');
        }
    }
    //============= #END# scopes ==============\\
}
