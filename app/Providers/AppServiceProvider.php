<?php

namespace App\Providers;

use App\Contracts\ProductCategoriesRepositoryInterface;
use App\Repositories\ProductCategoriesRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProductCategoriesRepositoryInterface::class, ProductCategoriesRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
