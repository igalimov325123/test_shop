<?php

namespace App\Providers;

use App\Repository\V1\CategoryRepositoryInterface;
use App\Repository\V1\Eloquent\BaseRepository;
use App\Repository\V1\Eloquent\CategoryRepository;
use App\Repository\V1\Eloquent\ProductRepository;
use App\Repository\V1\EloquentRepositoryInterface;
use App\Repository\V1\ProductRepositoryInterface;
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
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
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
