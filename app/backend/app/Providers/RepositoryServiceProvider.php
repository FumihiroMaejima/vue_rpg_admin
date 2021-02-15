<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\AuthInfo\AuthInfoRepositoryTestInterface;
use App\Repositories\AuthInfo\AuthInfoDBRepository;
// use App\Repositories\AuthInfo\AuthInfoEQRepository;
use App\Repositories\AuthInfo\AuthInfoRepositoryInterface;
use App\Repositories\AuthInfo\AuthInfoRepository;

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
            AuthInfoRepositoryTestInterface::class,
            AuthInfoDBRepository::class,
            // AuthInfoEQRepository::class,
        );
        $this->app->bind(AuthInfoRepositoryInterface::class, AuthInfoRepository::class);
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
