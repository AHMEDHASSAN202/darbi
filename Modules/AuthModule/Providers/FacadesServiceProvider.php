<?php

namespace Modules\AuthModule\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\AuthModule\Facades\OTP\MsegatOTP;

class FacadesServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('OTP', function () {
            return new MsegatOTP();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
