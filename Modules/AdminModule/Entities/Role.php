<?php

namespace Modules\AdminModule\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Role extends Model
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
    public function scopeAdminSearch($query)
    {
        if ($q = request()->q) {
            return $query->where('name', 'LIKE', '%' . $q .'%');
        }
    }
    //============= #END# scopes ==============\\
}
