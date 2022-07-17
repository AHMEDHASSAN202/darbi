<?php

namespace Modules\NotificationsModule\Jobs;

use App\Proxy\Proxy;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Arr;
use Modules\NotificationsModule\Entities\NotificationsCenter;
use Modules\NotificationsModule\Enums\NotificationReceiverTypes;
use Modules\NotificationsModule\Proxy\NotificationProxy;
use Modules\NotificationsModule\Services\NotificationService;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $notificationsCenter;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(NotificationsCenter $notificationsCenter)
    {
        $this->notificationsCenter = $notificationsCenter;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $notificationService = app(NotificationService::class);
        $title = translateAttribute($this->notificationsCenter->title);
        $message = translateAttribute($this->notificationsCenter->message);

        if ($this->notificationsCenter->receiver_type == NotificationReceiverTypes::ALL) {
            return $notificationService->sendToAll($title, $message);
        }

        $filters = [];
        switch ($this->notificationsCenter->receiver_type) {
            case NotificationReceiverTypes::USERS:
                $filters = ['type' => 'users'];
                break;
            case NotificationReceiverTypes::VENDORS:
                $filters = ['type' => 'vendors'];
                break;
            case NotificationReceiverTypes::SPECIFIED:
                $filters = [
                    'type'      => 'specified',
                    'receivers' => array_map(function ($receiver) {
                        return ['user_id' => (string)$receiver['user_id'], 'on_model' => $receiver['on_model']];
                    }, $this->notificationsCenter->receivers)
                ];
                break;
        }

        //get players
        $notificationProxy = new NotificationProxy("GET_PLAYERS", $filters);
        $proxy = new Proxy($notificationProxy);
        $playersResponse = $proxy->result();

        if (!empty($playersResponse)) {
            $players = Arr::pluck($playersResponse, 'phone_uuid');
            $notificationService->sendToUsers($title, $message, array_unique(array_values($players)));
        }
    }
}
