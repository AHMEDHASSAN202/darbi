<?php

namespace Modules\CommonModule\Observers;


use Illuminate\Support\Facades\Log;
use Modules\CommonModule\Entities\Setting;

class SettingObserver
{
    /**
     * Handle the Setting "created" event.
     *
     * @param  \Modules\CommonModule\Entities\Setting  $setting
     * @return void
     */
    public function created(Setting $setting)
    {
        //
    }

    /**
     * Handle the Setting "updated" event.
     *
     * @param  \Modules\CommonModule\Entities\Setting  $setting
     * @return void
     */
    public function updated(Setting $setting)
    {
        try {
            activities()->log('update', $setting, 'Update Settings');
        }catch (\Exception $exception) {
            Log::error("Can't log update setting", $setting->toArray());
        }
    }

    /**
     * Handle the Setting "deleted" event.
     *
     * @param  \Modules\CommonModule\Entities\Setting  $setting
     * @return void
     */
    public function deleted(Setting $setting)
    {
        //
    }

    /**
     * Handle the Setting "restored" event.
     *
     * @param  \Modules\CommonModule\Entities\Setting  $setting
     * @return void
     */
    public function restored(Setting $setting)
    {
        //
    }

    /**
     * Handle the Setting "force deleted" event.
     *
     * @param  \Modules\CommonModule\Entities\Setting  $setting
     * @return void
     */
    public function forceDeleted(Setting $setting)
    {
        //
    }
}
