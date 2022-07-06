<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\NotificationsModule\Services;

use App\Proxy\Proxy;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Modules\CommonModule\Traits\ImageHelperTrait;
use Modules\CommonModule\Transformers\PaginateResource;
use Modules\NotificationsModule\Enums\NotificationReceiverTypes;
use Modules\NotificationsModule\Http\Controllers\User\NotificationController;
use Modules\NotificationsModule\Http\Requests\CreateNotificationRequest;
use Modules\NotificationsModule\Proxy\NotificationProxy;
use Modules\NotificationsModule\Repositories\NotificationRepository;
use Modules\NotificationsModule\Transformers\NotificationResource;
use MongoDB\BSON\ObjectId;

class NotificationService
{
    private $notificationRepository;

    use ImageHelperTrait;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }


    public function listOfMyNotifications($request)
    {
        $notifications = $this->notificationRepository->listOfMyNotifications($request);

        if ($notifications instanceof LengthAwarePaginator) {
            return new PaginateResource(NotificationResource::collection($notifications));
        }

        return NotificationResource::collection($notifications);
    }


    public function findAll(Request $request)
    {
        $notifications = $this->notificationRepository->findAll($request);

        if ($notifications instanceof LengthAwarePaginator) {
            return new PaginateResource(\Modules\NotificationsModule\Transformers\Admin\NotificationResource::collection($notifications));
        }

        return \Modules\NotificationsModule\Transformers\Admin\NotificationResource::collection($notifications);
    }


    public function sendToUsers($title, $message, $players, $subtitle = null, $url = null, $data = null, $buttons = null, $schedule = null)
    {
        try {
            OneSignal::sendNotificationToUser(
                $message,
                $players,
                $url,
                $data,
                $buttons,
                $schedule,
                $title,
                $subtitle
            );

            return [
                'data'          => [],
                'statusCode'    => 200,
                'message'       => ''
            ];

        }catch (\Exception $exception) {
            Log::error(NotificationController::class . ' -> ' . HelperNotificationService::class . ' -> ' . __METHOD__ . ': ' . $exception->getMessage());
            return [
                'data'          => [],
                'statusCode'    => 500,
                'message'       => __("Can't send Notifications")
            ];
        }
    }


    public function sendToAll($title, $message, $subtitle = null, $url = null, $data = null, $buttons = null, $schedule = null)
    {
        try {

            OneSignal::sendNotificationToAll(
                $message,
                $url,
                $data,
                $buttons,
                $schedule,
                $title,
                $subtitle
            );

            return [
                'data'          => [],
                'statusCode'    => 200,
                'message'       => ''
            ];

        }catch (\Exception $exception) {
            Log::error(NotificationController::class . ' -> ' . HelperNotificationService::class . ' -> ' . __METHOD__ . ': ' . $exception->getMessage());
            return [
                'data'          => [],
                'statusCode'    => 500,
                'message'       => __("Can't send Notifications")
            ];
        }
    }


    public function create(CreateNotificationRequest $createNotificationRequest)
    {
        $image = null;
        if ($createNotificationRequest->hasFile('image')) {
            $image = $this->uploadImage('notifications', $createNotificationRequest->image);
        }

        $receivers = $this->getReceivers($createNotificationRequest);

        foreach ($receivers as $receiver) {
            $notification = $this->notificationRepository->create([
                'title' => $createNotificationRequest->title,
                'message' => $createNotificationRequest->message,
                'url' => $createNotificationRequest->url,
                'image' => $image,
                'receivers' => $receiver,
                'notification_type' => $createNotificationRequest->notification_type,
                'receiver_type' => $createNotificationRequest->receiver_type
            ]);

            if (!$notification) {
                Log::error('Create_Notification: ' . __CLASS__ . ' -> ' . __METHOD__ . ' -> Unable to create new notification');
                return [
                    'data'       => [],
                    'message'    => __('Unable to create new notification'),
                    'statusCode' => 500
                ];
            }
        }

        return [
            'data'       => [],
            'message'    => __('Data has been added successfully'),
            'statusCode' => 201
        ];
    }


    private function getReceivers(Request $request)
    {
        switch ($request->receiver_type) {
            case NotificationReceiverTypes::ALL:
                $vendors = $this->getVendorReceivers();
                $users = $this->getUserReceivers();
                $receivers = array_merge($vendors, $users);
                break;
            case NotificationReceiverTypes::USERS:
                $receivers = $this->getUserReceivers();
                break;
            case NotificationReceiverTypes::VENDORS:
                $receivers = $this->getVendorReceivers();
                break;
            case NotificationReceiverTypes::SPECIFIED:
                $receivers = array_map(function ($receiver) { return ['user_id' => new ObjectId($receiver['id']), 'on_model' => $receiver['type']]; }, $request->receivers);
                break;
            default:
                $receivers = [];
        }

        return array_chunk($receivers, 500);
    }


    private function getUserReceivers()
    {
        $notificationProxy = new NotificationProxy('GET_USERS');
        $proxy = new Proxy($notificationProxy);
        $users = $proxy->result() ?? [];
        return array_map(function ($user) { return ['user_id' => new ObjectId($user['id']), 'on_model' => 'user']; }, $users);
    }


    private function getVendorReceivers()
    {
        $notificationProxy = new NotificationProxy('GET_VENDOR_ADMIN', ['type' => 'vendor']);
        $proxy = new Proxy($notificationProxy);
        $adminVendors = $proxy->result() ?? [];
        return array_map(function ($admin) { return ['user_id' => new ObjectId($admin['id']), 'on_model' => 'admin']; }, $adminVendors);
    }
}
