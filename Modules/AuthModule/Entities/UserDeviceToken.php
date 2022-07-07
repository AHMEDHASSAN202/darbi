<?php

namespace Modules\AuthModule\Entities;

use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Modules\AuthModule\Services\AdminService;
use MongoDB\BSON\ObjectId;

class UserDeviceToken extends Base
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\AuthModule\Database\factories\UserDeviceTokenFactory::new();
    }


    //============= Scopes ====================\\

    public function scopeFilters($query, Request $request)
    {
        if ($userId = $request->get('user')) {
            $query->where('user_details.id', new ObjectId($userId))->where('user_details.on_model', User::class);
        }

        if ($type = $request->get('type')) {
            switch ($type) {
                case 'users':
                    $query->where('user_details.on_model', User::class);
                    break;
                case 'vendors':
                    $query->where('user_details.on_model', Admin::class);
                    break;
                case 'specified':
                    $users = [];
                    $vendorAdmins = [];
                    array_map(function ($receiver) use (&$users, &$vendorAdmins) {
                        if ($receiver['on_model'] == 'user') {
                            $users[] = new ObjectId($receiver['user_id']);
                        }elseif ($receiver['on_model'] == 'vendor') {
                            $vendorAdmins[] = new ObjectId($receiver['user_id']);
                        }
                    }, $request->get('receivers'));
                    $query->where(function ($q) use ($users, $vendorAdmins) {
                        $q->where(function ($qq) use ($users) {
                            $qq->whereIn('user_details.id', $users)->where('user_details.on_model', User::class);
                        })->orWhere(function ($qq) use ($vendorAdmins) {
                            $qq->whereIn('user_details.id', $vendorAdmins)->where('user_details.on_model', Admin::class);
                        });
                    });
                    break;
            }
        }

        if ($request->get('vendor')) {
            $vendorAdmins = app(AdminService::class)->findAllIds($request);
            $query->whereIn('user_details.id', generateObjectIdOfArrayValues($vendorAdmins->pluck('id')->toArray($request)))->where('user_details.on_model', Admin::class);
        }
    }

    //============= #END# Scopes ================\\
}
