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
                    $query->where('user_details.on_model', VendorAdmin::class);
                    break;
                case 'admins':
                    $query->where('user_details.on_model', SuperAdmin::class);
                    break;
                case 'specified':
                    $users = [];
                    $admins = [];

                    array_map(function ($receiver) use (&$users, &$admins) {
                        if ($receiver['on_model'] == 'user') {
                            $users[] = new ObjectId($receiver['user_id']);
                        }elseif ($receiver['on_model'] == 'admin') {
                            $admins[] = new ObjectId($receiver['user_id']);
                        }
                    }, $request->get('receivers'));

                    $query->where(function ($q) use ($users, $admins) {
                        $q->where(function ($qq) use ($users) {
                            $qq->whereIn('user_details.id', $users)->where('user_details.on_model', User::class);
                        })->orWhere(function ($qq) use ($admins) {
                            $qq->whereIn('user_details.id', $admins)->whereIn('user_details.on_model', [VendorAdmin::class, SuperAdmin::class]);
                        });
                    });

                    break;
            }
        }

        if ($request->get('vendor')) {
            $vendorAdmins = @app(AdminService::class)->findAllIds($request)['admins'];
            if ($vendorAdmins) {
                $query->whereIn('user_details.id', generateObjectIdOfArrayValues($vendorAdmins->pluck('id')->toArray($request)))->where('user_details.on_model', VendorAdmin::class);
            }
        }
    }

    //============= #END# Scopes ================\\
}
