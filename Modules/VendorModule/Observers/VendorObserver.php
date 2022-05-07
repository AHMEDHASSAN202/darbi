<?php

namespace Modules\VendorModule\Observers;


use Modules\VendorModule\Entities\Vendor;

class VendorObserver
{
    /**
     * Handle the Vendor "created" event.
     *
     * @param  \Modules\VendorModule\Entities\Vendor  $vendor
     * @return void
     */
    public function created(Vendor $vendor)
    {
        //
    }

    /**
     * Handle the Vendor "updated" event.
     *
     * @param \Modules\VendorModule\Entities\Vendor  $vendor
     * @return void
     */
    public function updated(Vendor $vendor)
    {
        //
    }

    /**
     * Handle the Vendor "deleted" event.
     *
     * @param \Modules\VendorModule\Entities\Vendor  $vendor
     * @return void
     */
    public function deleted(Vendor $vendor)
    {
        //
    }

    /**
     * Handle the Vendor "restored" event.
     *
     * @param \Modules\VendorModule\Entities\Vendor  $vendor
     * @return void
     */
    public function restored(Vendor $vendor)
    {
        //
    }

    /**
     * Handle the Vendor "force deleted" event.
     *
     * @param \Modules\VendorModule\Entities\Vendor  $vendor
     * @return void
     */
    public function forceDeleted(Vendor $vendor)
    {
        //
    }
}
