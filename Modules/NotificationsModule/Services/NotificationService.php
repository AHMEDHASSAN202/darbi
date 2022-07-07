<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\NotificationsModule\Services;

use App\Proxy\Proxy;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CommonModule\Traits\ImageHelperTrait;
use Modules\CommonModule\Transformers\PaginateResource;
use Modules\NotificationsModule\Enums\NotificationReceiverTypes;
use Modules\NotificationsModule\Http\Requests\CreateNotificationRequest;
use Modules\NotificationsModule\Proxy\NotificationProxy;
use Modules\NotificationsModule\Repositories\NotificationRepository;
use Modules\NotificationsModule\Transformers\Admin\FindNotificationResource;
use Modules\NotificationsModule\Transformers\NotificationResource;
use MongoDB\BSON\ObjectId;
use OneSignal;

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
        try {

            $notifications = $this->notificationRepository->findAll($request);

            if ($notifications instanceof LengthAwarePaginator) {
                return serviceResponse(new PaginateResource(\Modules\NotificationsModule\Transformers\Admin\NotificationResource::collection($notifications)));
            }

            return serviceResponse(\Modules\NotificationsModule\Transformers\Admin\NotificationResource::collection($notifications));

        }catch (\Exception $exception) {
            helperLog(__CLASS__, __FUNCTION__, $exception->getMessage());
            return serviceResponse([], 500, __("Get notifications error"));
        }
    }


    public function find($id)
    {
        $notification = $this->notificationRepository->find($id);

        if (!$notification) {
            helperLog(__CLASS__, __FUNCTION__, 'Notification not found');
            return serviceResponse([], 500, __("Notification not found"));
        }

        return serviceResponse(new FindNotificationResource($notification));
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

            return serviceResponse([]);

        }catch (\Exception $exception) {
            helperLog(__CLASS__, __FUNCTION__, $exception->getMessage());
            return serviceResponse([], 500, __("Can't send Notifications"));
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

            return serviceResponse([]);

        }catch (\Exception $exception) {
            helperLog(__CLASS__, __FUNCTION__, $exception->getMessage());
            return serviceResponse([], 500, __("Can't send Notifications"));
        }
    }


    public function create(CreateNotificationRequest $createNotificationRequest)
    {
        $image = null;
        if ($createNotificationRequest->hasFile('image')) {
            $image = $this->uploadImage('notifications', $createNotificationRequest->image);
        }

        $notification = $this->notificationRepository->create([
            'title'             => $createNotificationRequest->title,
            'message'           => $createNotificationRequest->message,
            'url'               => $createNotificationRequest->url,
            'image'             => $image,
            'receivers'         => $this->getReceivers($createNotificationRequest),
            'notification_type' => $createNotificationRequest->notification_type,
            'receiver_type'     => $createNotificationRequest->receiver_type,
            'extra_data'        => $createNotificationRequest->extra_data ?? []
        ]);

        if (!$notification) {
            helperLog(__CLASS__, __FUNCTION__, 'Unable to create new notification');
            return serviceResponse([], 500, __("Unable to create new notification"));
        }

        return serviceResponse([], 201, __('Data has been added successfully'));
    }


    private function getReceivers(Request $request)
    {
        switch ($request->receiver_type) {
//            case NotificationReceiverTypes::ALL:
//                $vendors = $this->getVendorReceivers();
//                $users = $this->getUserReceivers();
//                $receivers = array_merge($vendors, $users);
//                break;
//            case NotificationReceiverTypes::USERS:
//                $receivers = $this->getUserReceivers();
//                break;
//            case NotificationReceiverTypes::VENDORS:
//                $receivers = $this->getVendorReceivers();
//                break;
            case NotificationReceiverTypes::SPECIFIED:
                $receivers = array_map(function ($receiver) { return ['user_id' => new ObjectId($receiver['id']), 'on_model' => $receiver['type']]; }, $request->receivers);
                break;
            default:
                $receivers = [];
        }

        return $receivers;
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
