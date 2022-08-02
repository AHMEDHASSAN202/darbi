<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Services;

use App\Proxy\Proxy;
use Modules\BookingModule\Enums\BookingStatus;
use Modules\BookingModule\Proxy\BookingProxy;

trait BookingHelperService
{
    private function updateEntityState($newState, $booking)
    {
        $entityState = match ($newState) {
            BookingStatus::ACCEPT => 'pending',
            BookingStatus::CANCELLED_AFTER_ACCEPT, BookingStatus::REJECTED, BookingStatus::FORCE_CANCELLED, BookingStatus::COMPLETED, BookingStatus::TIMEOUT => 'free',
            BookingStatus::PICKED_UP => 'reserved',
            default => null,
        };

        if (!$entityState) {
            return;
        }

        $bookingProxy = new BookingProxy('UPDATE_ENTITY_STATE', ['id' => $booking->entity_id, 'state' => $entityState]);

        $entityId = (new Proxy($bookingProxy))->result();

        if (!$entityId) {
            //return exception for execute transaction rollback (update booking action)
            throw new \Exception("Can't update entity state");
        }
    }
}
