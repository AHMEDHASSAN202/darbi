<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Enums;

class BookingStatus
{
    const INIT = 'init';
    const PENDING = 'pending';
    const ACCEPT = 'accepted';
    const PAID = 'paid';
    const CANCELLED_BEFORE_ACCEPT = 'cancelled_before_accept';
    const CANCELLED_AFTER_ACCEPT = 'cancelled_after_accept';
    const REJECTED = 'rejected';
    const PICKED_UP = 'picked_up';
    const DROPPED = 'dropped';
    const COMPLETED = 'completed';
    const FORCE_CANCELLED = 'force_cancelled';
}
