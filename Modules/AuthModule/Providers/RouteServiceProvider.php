<?php

namespace Modules\AuthModule\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleNamespace = 'Modules\AuthModule\Http\Controllers';


    protected $moduleNamespaceUser = 'Modules\AuthModule\Http\Controllers\User';


    protected $moduleNamespaceAdmin = 'Modules\AuthModule\Http\Controllers\Admin';


    protected $moduleNamespaceInternal = 'Modules\AuthModule\Http\Controllers\Internal';

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

        $this->mapApiInternalRoutes();
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
            ->group(module_path('AuthModule', '/Routes/web.php'));
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
            ->namespace($this->moduleNamespaceUser)
            ->group(module_path('AuthModule', '/Routes/api.php'));
    }

    /**
     * Define the "api admin" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiAdminRoutes()
    {
        Route::prefix('api/admin/v1')
            ->middleware('api')
            ->namespace($this->moduleNamespaceAdmin)
            ->group(module_path('AuthModule', '/Routes/admin.php'));
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
            ->namespace($this->moduleNamespaceAdmin)
            ->group(module_path('AuthModule', '/Routes/vendor.php'));
    }

    /**
     * Define the "api vendor" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiInternalRoutes()
    {
        Route::prefix('api/internal/v1')
            ->middleware(['api', 'internal'])
            ->namespace($this->moduleNamespaceInternal)
            ->group(module_path('AuthModule', '/Routes/internal.php'));
    }
}
