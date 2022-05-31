<?php

namespace Modules\AuthModule\Entities;

use App\Eloquent\BaseAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\AuthModule\Database\factories\UserFactory;
use Modules\CommonModule\Entities\Country;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends BaseAuthenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $guarded = [];

    protected $hidden = ['password', 'remember_token', 'deleted_at'];

    protected $casts = ['email_verified_at' => 'datetime'];

    protected $dates = ['last_login'];

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

    public function country()
    {
        return $this->belongsTo(Country::class);
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

    //=================== helpers ===================\\

    public function isNotActive()
    {
        return $this->is_active !== true;
    }

    //=================== #END# helpers ===================\\
}
