<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
            $this->app->bind('App\Services\Contracts\ApiInterface', 'App\Services\Api');
            $this->app->singleton(Client::class, function ($app) {
                return new Client([
                    'base_uri' => env('BASE_URI'),
                    'timeout'  => env('CLIENT_TIMEOUT'),
                ]);
            });
    }
}
