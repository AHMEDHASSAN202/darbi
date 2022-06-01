<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Jenssegers\Mongodb\Eloquent\Builder;
use Modules\TelescopeModule\Providers\TelescopeServiceProvider;
use MongoDB\BSON\ObjectId;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Builder::macro('whereHas', function () {
            dd($this);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        RateLimiter::for('auth', function (Request $request) {
            return [
                Limit::perMinute(30)->by($request->ip()),
            ];
        });
    }
}
