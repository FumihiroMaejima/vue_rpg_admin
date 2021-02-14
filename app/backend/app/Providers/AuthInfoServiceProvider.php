<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AuthInfoService;
use App\Repositories\AuthInfo\AuthInfoRepositoryInterface;

class AuthInfoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'AuthInfoService', AuthInfoService::class
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
