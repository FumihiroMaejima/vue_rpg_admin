<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Repositories\AuthInfo\AuthInfoRepositoryTestInterface::class,
            \App\Repositories\AuthInfo\AuthInfoDBRepository::class
            // \App\Repositories\AuthInfo\AuthInfoEQRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
