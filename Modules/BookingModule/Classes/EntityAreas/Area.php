<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Classes\EntityAreas;

class Area
{
    private $entity;

    private $types = [
        'car'        => BranchArea::class,
        'yacht'      => PortArea::class
    ];

    private $errorMessage = '';


    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    public function getDetails()
    {
        $entityType = arrayGet($this->entity, 'type');

        if (!$entityType) {
            $this->errorMessage = __('Internal server error');
            return null;
        }

        $areaClass = arrayGet($this->types, $entityType);

        if (!$areaClass) {
            $this->errorMessage = __('Internal server error');
            return null;
        }

        $areaObject = new $areaClass($this->entity);

        $areaDetails = $areaObject->getType();

        if (empty($areaObject)) {
            $this->errorMessage = $areaObject->getErrorMessage();
        }

        return $areaDetails;
    }

    public function getError()
    {
        return $this->errorMessage;
    }
}
