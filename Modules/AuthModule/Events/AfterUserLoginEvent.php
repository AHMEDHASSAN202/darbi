<?php

namespace Modules\AuthModule\Events;

use Illuminate\Queue\SerializesModels;
use Modules\AuthModule\Entities\User;

class AfterUserLoginEvent
{
    use SerializesModels;

    private $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
