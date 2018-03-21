<?php

namespace App\Providers;

use App\Service\ParsehubService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->when(ParsehubService::class)
                  ->needs('$parsehubConfig')
                  ->give(config('parsehub'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
