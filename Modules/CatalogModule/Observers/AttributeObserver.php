<?php

namespace Modules\CatalogModule\Observers;

use Modules\CatalogModule\Entities\Attribute;
use Modules\CommonModule\Traits\ImageHelperTrait;

class AttributeObserver
{
    use ImageHelperTrait;

    /**
     * Handle the Brand "created" event.
     *
     * @param  \Modules\CatalogModule\Entities\Attribute  $attribute
     * @return void
     */
    public function creating(Attribute $attribute)
    {

    }

    /**
     * Handle the Brand "created" event.
     *
     * @param  \Modules\CatalogModule\Entities\Attribute  $attribute
     * @return void
     */
    public function created(Attribute $attribute)
    {

    }

    /**
     * Handle the Brand "updated" event.
     *
     * @param  \Modules\CatalogModule\Entities\Attribute  $attribute
     * @return void
     */
    public function updated(Attribute $attribute)
    {
        if ($attribute->wasChanged('image')) {
            $this->_removeImage($attribute->getOriginal('image'));
        }
    }

    /**
     * Handle the Brand "deleted" event.
     *
     * @param  \Modules\CatalogModule\Entities\Attribute  $attribute
     * @return void
     */
    public function deleted(Attribute $attribute)
    {

    }

    /**
     * Handle the Brand "restored" event.
     *
     * @param  \Modules\CatalogModule\Entities\Attribute  $attribute
     * @return void
     */
    public function restored(Attribute $attribute)
    {

    }

    /**
     * Handle the Brand "force deleted" event.
     *
     * @param  \Modules\CatalogModule\Entities\Attribute  $attribute
     * @return void
     */
    public function forceDeleted(Attribute $attribute)
    {

    }
}
