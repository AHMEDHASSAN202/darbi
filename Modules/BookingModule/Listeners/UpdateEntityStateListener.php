<?php

namespace Modules\BookingModule\Listeners;

use App\Proxy\Proxy;
use Modules\BookingModule\Enums\BookingStatus;
use Modules\BookingModule\Events\BookingStatusChangedEvent;
use Modules\BookingModule\Proxy\BookingProxy;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UpdateEntityStateListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param BookingStatusChangedEvent $event
     * @return void
     */
    public function handle(BookingStatusChangedEvent $event)
    {
        switch ($event->booking->status) {
            case BookingStatus::ACCEPT:
                $entityState = 'pending';
                break;
            case BookingStatus::CANCELLED_AFTER_ACCEPT:
            case BookingStatus::REJECTED:
            case BookingStatus::FORCE_CANCELLED:
            case BookingStatus::COMPLETED:
                $entityState = 'free';
                break;
            case BookingStatus::PICKED_UP:
                $entityState = 'reserved';
                break;
            default:
                $entityState = null;
                break;
        }

        if (!$entityState) {
            return;
        }

        $entityId = $this->updateEntityState((string)$event->booking->entity_id, $entityState);

        //return exception for execute transaction rollback (update booking action)
        abort_if(!$entityId, 500);
    }



    private function updateEntityState($entityId, $state)
    {
        $bookingProxy = new BookingProxy('UPDATE_ENTITY_STATE', ['id' => $entityId, 'state' => $state]);

        return (new Proxy($bookingProxy))->result();
    }
}
