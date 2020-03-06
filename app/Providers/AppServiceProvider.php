<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Repositories\ActiveDirectory;
use App\Repositories\Schedules;
use App\Repositories\Programs;
use GuzzleHttp\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // bind Medhub API object into service container
        $this->app->singleton(Client::class, function ($app) {
            return new Client(config('app.guzzle_http'));
        });

        // bind redis repositories into service container for easy DI
        $this->app->singleton(ActiveDirectory::class, function ($app) {
            return new ActiveDirectory(
                $app->make(Programs::class), $app->make(Client::class));
        });

        $this->app->singleton(Programs::class, function ($app) {
            return new Programs(
                $app->make(Client::class));
        });

        $this->app->singleton(Schedules::class, function ($app) {
            return new Schedules(
                $app->make(Client::class), config('app.program_id'));
        });
    }
}
