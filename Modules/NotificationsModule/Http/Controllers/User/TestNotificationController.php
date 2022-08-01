<?php

namespace Modules\NotificationsModule\Http\Controllers\User;

use Berkayk\OneSignal\OneSignalClient;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AuthModule\Entities\User;
use Modules\AuthModule\Entities\UserDeviceToken;
use MongoDB\BSON\ObjectId;
use OneSignal;

class TestNotificationController extends Controller
{
    public function send(Request $request)
    {
        OneSignal::sendNotificationToUser($request->get('title', 'Test'), [$request->device_token]);
        return;
        $request->validate(['user_id' => 'required']);

        $title = $request->get('title', 'TitleTest');

        $tokens = UserDeviceToken::where('user_details.id', new ObjectId($request->user_id))->where('user_details.on_model', User::class)->get();

        try {
            OneSignal::sendNotificationToUser($title, $tokens->pluck('phone_uuid')->toArray());
        }catch (\Exception $exception) {
            dd($exception);
        }
    }


    public function sendAll(Request $request)
    {
        $title = $request->get('title', 'TitleTest');

        try {
            OneSignal::sendNotificationToAll($title);
        }catch (\Exception $exception) {
            dd($exception);
        }
    }
}
