<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\NotificationsModule\Services;

use Illuminate\Http\Request;
use Modules\CommonModule\Transformers\PaginateResource;
use Modules\NotificationsModule\Repositories\NotificationRepository;
use Modules\NotificationsModule\Transformers\NotificationResource;

class NotificationService
{
    private $notificationRepository;

    use HelperNotificationService;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function listOfMyNotifications($request)
    {
        return new PaginateResource(NotificationResource::collection($this->notificationRepository->listOfMyNotifications($request)));
    }
}
