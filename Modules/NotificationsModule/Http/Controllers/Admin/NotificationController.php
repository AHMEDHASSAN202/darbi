<?php

namespace Modules\NotificationsModule\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CommonModule\Traits\ApiResponseTrait;
use Modules\NotificationsModule\Http\Requests\CreateNotificationRequest;
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


    public function store(CreateNotificationRequest $createNotificationRequest)
    {
        $result = $this->notificationService->create($createNotificationRequest);

        return $this->apiResponse($result['data'], $result['statusCode'], $result['message']);
    }
}
