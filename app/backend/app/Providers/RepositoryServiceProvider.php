<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\AuthInfo\AuthInfoRepositoryTestInterface;
use App\Repositories\AuthInfo\AuthInfoDBRepository;
// use App\Repositories\AuthInfo\AuthInfoEQRepository;
use App\Repositories\AuthInfo\AuthInfoRepositoryInterface;
use App\Repositories\AuthInfo\AuthInfoRepository;
use App\Repositories\Admins\AdminsRepositoryInterface;
use App\Repositories\Admins\AdminsRepository;
use App\Repositories\AdminsRoles\AdminsRolesRepositoryInterface;
use App\Repositories\AdminsRoles\AdminsRolesRepository;
use App\Repositories\Roles\RolesRepository;
use App\Repositories\Roles\RolesRepositoryInterface;

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
        $this->app->bind(AdminsRepositoryInterface::class, AdminsRepository::class);
        $this->app->bind(AdminsRolesRepositoryInterface::class, AdminsRolesRepository::class);
        $this->app->bind(RolesRepositoryInterface::class, RolesRepository::class);
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
