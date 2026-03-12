<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/login';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
        Route::macro('dashboardModule', function (
            string $prefix,
            string $controller,
            string $namePrefix,
            ?string $permissionBase = null,
            array $actions = ['view', 'getdata', 'store', 'update', 'delete', 'active', 'inactive'],
            ?callable $extras = null // ✅ هنا الجديد
        ) {
            Route::prefix($prefix)
                ->name($namePrefix)
                ->controller($controller)
                ->group(function () use ($permissionBase, $actions, $extras) {

                    $map = [
                        'view'     => ['GET',  '/',        'view',       'view'],
                        'getdata'  => ['GET',  '/getdata', 'getdata',    'view'],
                        'store'    => ['POST', '/store',   'store',      'store'],
                        'update'   => ['POST', '/update',  'update',     'update'],
                        'delete'   => ['POST', '/delete',  'delete',     'delete'],
                        'active'   => ['POST', '/active',  'active',     'active'],
                        'inactive' => ['POST', '/inactive', 'inactive',  'active'],
                    ];

                    foreach ($actions as $action) {
                        if (!isset($map[$action])) continue;

                        [$method, $uri, $handler, $permAction] = $map[$action];

                        $route = match ($method) {
                            'GET'  => Route::get($uri, $handler),
                            'POST' => Route::post($uri, $handler),
                            default => null,
                        };

                        if ($route) {
                            $route->name($action);

                            // ✅ بس إذا في permissionBase طبّق permission middleware
                            if (!empty($permissionBase)) {
                                $route->middleware("permission:$permissionBase.$permAction");
                            }
                        }
                    }

                    // ✅ routes إضافية (زي permissionsChecked)
                    if (is_callable($extras)) {
                        $extras($permissionBase);
                    }
                });
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
