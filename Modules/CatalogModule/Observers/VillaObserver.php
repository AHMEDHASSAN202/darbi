<?php

namespace Modules\CatalogModule\Observers;

use Modules\CatalogModule\Entities\Villa;
use Modules\CatalogModule\Enums\EntityStatus;
use Modules\CatalogModule\Enums\EntityType;

class VillaObserver
{
    public function creating(Villa $villa)
    {
        $villa->type = EntityType::VILLA;
        $villa->state = EntityStatus::FREE;
    }
}
