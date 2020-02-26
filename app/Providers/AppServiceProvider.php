<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\GuzzleClient;

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
            $this->app->bind('App\Repositories\Contracts\BitcoinInterface', 'App\Repositories\BitcoinRepository');

            $this->app->singleton(GuzzleClient::class, function ($app) {
                return new GuzzleClient([
                    'base_uri' => env('BASE_URI'),
                    'timeout'  => env('CLIENT_TIMEOUT'),
                ]);
            });
    }
}
