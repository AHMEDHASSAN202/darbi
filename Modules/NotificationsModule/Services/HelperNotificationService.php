<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\NotificationsModule\Services;

use Illuminate\Http\Request;
use OneSignal;

trait HelperNotificationService
{
    public function sendToUsers(Request $request)
    {
        try {
            $notification = OneSignal::sendNotificationToUser(
                                $request->title,
                                $request->tokens,
                                $request->url,
                                $request->data,
                                $request->buttons,
                                $request->schedule,
                                $request->headings,
                                $request->subtitle
                            );

            dd($notification);

        }catch (\Exception $exception) {
            dd($exception);
        }
    }


    public function sendToAll(Request $request)
    {
        try {
            $notificationAll = OneSignal::sendNotificationToAll(
                $request->title,
                $request->url,
                $request->data,
                $request->buttons,
                $request->schedule,
                $request->headings,
                $request->subtitle
            );

            dd($notificationAll);

        }catch (\Exception $exception) {
            dd($exception);
        }
    }
}
