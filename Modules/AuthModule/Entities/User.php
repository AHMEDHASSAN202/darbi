<?php

namespace Modules\AuthModule\Entities;

use App\Eloquent\BaseAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Modules\AuthModule\Database\factories\UserFactory;
use Modules\BookingModule\Entities\Booking;
use Modules\CommonModule\Entities\Country;
use MongoDB\BSON\ObjectId;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends BaseAuthenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;


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
        if ($phone = $request->get('phone')) {
            $query->where('phone', 'LIKE', '%' . $phone . '%');
        }

        if ($request->get('active')) {
            $query->where('is_active', true);
        }

        if ($userId = $request->get('userId')) {
            $query->where('_id', new ObjectId($userId));
        }
    }
    //============= #END# scopes ==============\\

    //=================== helpers ===================\\

    public function isNotActive()
    {
        return $this->is_active !== true;
    }

    //=================== #END# helpers ===================\\

    //=================== Bookings =========================\\

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function lastBooking()
    {
        return $this->hasOne(Booking::class, 'user_id')->latest();
    }

    //=================== #END# Bookings =========================\\
}
