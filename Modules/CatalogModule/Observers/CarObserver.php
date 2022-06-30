<?php

namespace Modules\CatalogModule\Observers;

use Modules\CatalogModule\Entities\Car;

class CarObserver
{
    public function creating(Car $car)
    {
        $car->type = 'car';
        $car->state = 'free';
    }
}
