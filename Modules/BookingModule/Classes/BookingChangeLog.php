<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Classes;

use Modules\BookingModule\Entities\Booking;
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

class BookingChangeLog
{
    private $booking;
    private $newStatus;
    private $me;

    public function __construct(Booking $booking, $newStatus, $me)
    {
        $this->booking = $booking;
        $this->newStatus = $newStatus;
        $this->me = $me;
    }

    public function logs() : array {
        $logs = $this->booking->status_change_log;

        if (!is_array($logs)) {
            $logs = [];
        }

        $logs[] = [
            'old_status'    => $this->booking->status,
            'new_status'    => $this->newStatus,
            'created_at'    => new \MongoDB\BSON\UTCDateTime(now()->timestamp),
            'changed_by'    => [
                'id'            => new ObjectId($this->me->_id),
                'model'         => get_class($this->me)
            ]
        ];

        return $logs;
    }
}
