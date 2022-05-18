<?php

namespace Modules\AuthModule\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Modules\AuthModule\Database\factories\UserFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use function request;

class User extends Model implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $guarded = [];

    protected $hidden = ['password', 'remember_token', 'deleted_at'];

    protected $casts = ['email_verified_at' => 'datetime'];

    public $preventActivityLog = ['password', 'remember_token'];

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
        return UserFactory::new();
    }

    //============= Relations ===================\\

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
