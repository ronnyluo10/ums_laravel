<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });

        Route::bind('pelanggan', function($value) {
            try {
                return \App\Models\Pelanggan::find(decrypt($value));
            } catch (\RuntimeException $e) {
                Log::info($e);
                return null;
            }
        });

        Route::bind('barang', function($value) {
            try {
                return \App\Models\Barang::find(decrypt($value));
            } catch (\RuntimeException $e) {
                Log::info($e);
                return null;
            }
        });

        Route::bind('penjualan', function($value) {
            try {
                return \App\Models\Penjualan::find(decrypt($value));
            } catch (\RuntimeException $e) {
                Log::info($e);
                return null;
            }
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
