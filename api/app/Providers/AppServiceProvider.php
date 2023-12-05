<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Core\UseCase\Shared\Interfaces\{
    TransactionInterface,
    FileStorageInterface
};

use App\Repositories\Transaction\DBTransaction;
use App\Services\Storage\FileStorage;


use Core\Domain\Product\Repository\ProductRepositoryInterface;
use Core\Domain\Category\Repository\CategoryRepositoryInterface;


use App\Repositories\Eloquent\{
    ProductEloquentRepository,
    CategoryEloquentRepository
};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->bindRepositories();
        $this->bindServices();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    private function bindRepositories() {
        $this->app->bind(
            TransactionInterface::class,
            DBTransaction::class,
        );

        $this->app->singleton(
            ProductRepositoryInterface::class,
            ProductEloquentRepository::class,
        );
        $this->app->singleton(
            CategoryRepositoryInterface::class,
            CategoryEloquentRepository::class,
        );
    }

    private function bindServices() {
        $this->app->singleton(
            FileStorageInterface::class,
            FileStorage::class
        );
    }
}
