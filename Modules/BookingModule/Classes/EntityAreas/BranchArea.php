<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Classes\EntityAreas;

use App\Proxy\Proxy;
use Modules\BookingModule\Proxy\BookingProxy;

class BranchArea implements EntityArea
{
    private $errorMessage = '';
    private $branchId;

    public function __construct($entity)
    {
        $this->branchId = arrayGet($entity, 'branch_id');
    }

    public function getType()
    {
        $bookingProxy = new BookingProxy('GET_BRANCH', ['branch_id' => $this->branchId]);
        $proxy = new Proxy($bookingProxy);
        $branch = $proxy->result();

        if (!$branch) {
            $this->errorMessage = __('Branch not exists');
        }

        return $branch;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
