<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Classes\EntityAreas;

use App\Proxy\Proxy;
use Modules\BookingModule\Proxy\BookingProxy;

class PortArea implements EntityArea
{
    private $errorMessage = '';
    private $portId;

    public function __construct($entity)
    {
        $this->portId = arrayGet($entity, 'port_id');
    }

    public function getType()
    {
        $bookingProxy = new BookingProxy('GET_PORT', ['port_id' => $this->portId]);
        $proxy = new Proxy($bookingProxy);
        $port = $proxy->result();

        if (empty($port)) {
            $this->errorMessage = __('Port not exists');
        }

        return $port;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
