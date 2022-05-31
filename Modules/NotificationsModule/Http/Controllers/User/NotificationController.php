<?php

namespace Modules\NotificationsModule\Http\Controllers\User;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CommonModule\Traits\ApiResponseTrait;
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
}
