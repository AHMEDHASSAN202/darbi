<?php

namespace Modules\CatalogModule\Observers;

use Modules\CatalogModule\Entities\Yacht;
use Modules\CatalogModule\Enums\EntityStatus;
use Modules\CatalogModule\Enums\EntityType;

class YachtObserver
{
    public function creating(Yacht $yacht)
    {
        $yacht->type = EntityType::YACHT;
        $yacht->state = EntityStatus::FREE;
    }
}
