<?php

namespace Modules\NotificationsModule\Http\Controllers\User;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CommonModule\Traits\ApiResponseTrait;
use Modules\NotificationsModule\Http\Requests\SendNotificationRequest;
use Modules\NotificationsModule\Services\NotificationService;

class NotificationController extends Controller
{
    use ApiResponseTrait;

    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function findAll(Request $request)
    {
        return $this->apiResponse([
            'notifications' => $this->notificationService->listOfMyNotifications($request)
        ]);
    }

    public function send(SendNotificationRequest $sendNotificationRequest)
    {
        return $this->notificationService->sendToUsers($sendNotificationRequest);
    }

    public function sendAll()
    {
        return $this->notificationService->sendToAll();
    }
}
