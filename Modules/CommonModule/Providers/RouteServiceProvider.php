<?php

namespace Modules\CommonModule\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleNamespace = 'Modules\CommonModule\Http\Controllers';

    protected $moduleNamespaceAdmin = 'Modules\CommonModule\Http\Controllers\Admin';

    protected $moduleNamespaceVendor = 'Modules\CommonModule\Http\Controllers\Admin\Vendor';

    protected $moduleNamespaceInternal = 'Modules\CommonModule\Http\Controllers\Internal';

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

        $this->mapApiCommonRoutes();

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
            ->group(module_path('CommonModule', '/Routes/web.php'));
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
            ->group(module_path('CommonModule', '/Routes/api.php'));
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
            ->group(module_path('CommonModule', '/Routes/admin.php'));
    }


    /**
     * Define the "api common" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiCommonRoutes()
    {
        Route::prefix('api/common/v1')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('CommonModule', '/Routes/common.php'));
    }


    /**
     * Define the "api common" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiVendorRoutes()
    {
        Route::prefix('api/vendor/v1')
            ->middleware('api')
            ->namespace($this->moduleNamespaceVendor)
            ->group(module_path('CommonModule', '/Routes/vendor.php'));
    }


    /**
     * Define the "api common" routes for the application.
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
            ->group(module_path('CommonModule', '/Routes/internal.php'));
    }
}
