<?php

namespace Modules\NotificationsModule\Entities;

use App\Eloquent\Base;
use App\Proxy\Proxy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Modules\NotificationsModule\Proxy\NotificationProxy;
use MongoDB\BSON\ObjectId;

class NotificationsCenter extends Base
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\NotificationsModule\Database\factories\NotificationsCenterFactory::new();
    }


    //================ Scopes =========================\\

    public function scopeSearch($query, Request $request)
    {
        if ($q = $request->get('q')) {
            $query->where(function ($query) use ($q) { $query->where('title.ar', 'LIKE', '%'.$q.'%')->orWhere('title.en', 'LIKE', '%'.$q.'%'); });
        }
    }

    public function scopeFilters($query, Request $request)
    {
        if ($notificationType = $request->get('notification_type')) {
            $query->where('notification_type', new ObjectId($notificationType));
        }

        if ($receiverType = $request->get('receiver_type')) {
            $query->where('receiver_type', new ObjectId($receiverType));
        }

        if ($userId = $request->get('user')) {
            $query->where('receivers.user_id', new ObjectId($userId));
        }

        if ($vendorId = $request->get('vendor')) {
            $notificationProxy = new NotificationProxy('GET_VENDOR_ADMIN', ['type' => 'vendor', 'vendor_id' => $vendorId]);
            $proxy = new Proxy($notificationProxy);
            $adminsVendor = $proxy->result() ?? [];
            $query->whereIn('receivers.user_id', generateObjectIdOfArrayValues($adminsVendor));
        }
    }

    //================ #END# scopes =========================
}
