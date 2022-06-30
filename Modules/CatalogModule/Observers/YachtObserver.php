<?php

namespace Modules\CatalogModule\Observers;

use Modules\CatalogModule\Entities\Yacht;

class YachtObserver
{
    public function creating(Yacht $yacht)
    {
        $yacht->type = 'yacht';
        $yacht->state = 'free';
    }
}
