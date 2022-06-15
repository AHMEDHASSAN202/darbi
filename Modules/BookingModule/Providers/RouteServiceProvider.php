<?php

namespace Modules\BookingModule\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleNamespace = 'Modules\BookingModule\Http\Controllers';

    protected $adminModuleNamespace = 'Modules\BookingModule\Http\Controllers\Admin';

    protected $vendorModuleNamespace = 'Modules\BookingModule\Http\Controllers\Admin\Vendor';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapApiAdminRoutes();

        $this->mapApiVendorRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->moduleNamespace)
            ->group(module_path('BookingModule', '/Routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api/mobile/v1')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('BookingModule', '/Routes/api.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiAdminRoutes()
    {
        Route::prefix('api/admin/v1')
            ->middleware('api')
            ->namespace($this->adminModuleNamespace)
            ->group(module_path('BookingModule', '/Routes/admin.php'));
    }


    /**
     * Define the "api vendor" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiVendorRoutes()
    {
        Route::prefix('api/vendor/v1')
            ->middleware('api')
            ->namespace($this->vendorModuleNamespace)
            ->group(module_path('BookingModule', '/Routes/vendor.php'));
    }
}
