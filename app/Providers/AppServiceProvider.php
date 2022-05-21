<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $repositories = config('repository');

        foreach($repositories as $key => $repository) {
            foreach ($repository as $controller) {
                $this->app->when($controller)
                    ->needs(\App\Library\Repository\Contracts\CRUDInterface::class)
                    ->give(function() use ($key) {
                        return new $key;
                    });
            }
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
