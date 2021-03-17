<?php

namespace Zoo;

use Illuminate\Support\ServiceProvider;

class ZooPackageProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/route.php');
        $this->loadMigrationsFrom(__DIR__. '/database/migrations');
    }
}
