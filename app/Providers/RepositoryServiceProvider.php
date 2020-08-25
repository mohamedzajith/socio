<?php

namespace App\Providers;

use App\Interfaces\AdminInterface;
use App\Interfaces\AuthenticateInterface;
use App\Interfaces\CustomerInterface;
use App\Interfaces\ProductInterface;
use App\Repositories\AdminRepository;
use App\Repositories\AuthenticateRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\ProductRepository;
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
        $this->app->bind(AdminInterface::Class, AdminRepository::Class);
        $this->app->bind(CustomerInterface::Class, CustomerRepository::Class);
        $this->app->bind(ProductInterface::Class, ProductRepository::Class);
        $this->app->bind(AuthenticateInterface::Class, AuthenticateRepository::Class);
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