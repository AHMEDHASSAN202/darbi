<?php

namespace Modules\CatalogModule\Observers;

use Modules\CatalogModule\Entities\Car;
use Modules\CatalogModule\Enums\EntityStatus;
use Modules\CatalogModule\Enums\EntityType;

class CarObserver
{
    public function creating(Car $car)
    {
        $car->type = EntityType::CAR;
        $car->state = EntityStatus::FREE;
    }
}
