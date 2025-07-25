<?php

namespace App\Providers;

use App\Http\Repository\CuponRepository;
use App\Http\Repository\ICuponRepository;
use App\Http\Repository\IOrderRepository;
use App\Http\Repository\IPaymentRepository;
use App\Http\Repository\IProductCategoryRepository;
use App\Http\Repository\IProductRepository;
use App\Http\Repository\ISupplierRepository;
use App\Http\Repository\IUserRepository;
use App\Http\Repository\OrderRepository;
use App\Http\Repository\PaymentRepository;
use App\Http\Repository\ProductCategoryRepository;
use App\Http\Repository\ProductRepository;
use App\Http\Repository\SupplierRepository;
use App\Http\Repository\UserRepository;
use IInventoryLogRepository;
use IInventoryOrderRepository;
use Illuminate\Support\ServiceProvider;
use InventoryLogRepository;
use InventoryOrderRepository;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IProductCategoryRepository::class, ProductCategoryRepository::class);
        $this->app->bind(ISupplierRepository::class, SupplierRepository::class);
        $this->app->bind(IProductRepository::class, ProductRepository::class);
        $this->app->bind(ICuponRepository::class, CuponRepository::class);
        $this->app->bind(IOrderRepository::class, OrderRepository::class);
        $this->app->bind(IPaymentRepository::class, PaymentRepository::class);
        $this->app->bind(IInventoryLogRepository::class, InventoryLogRepository::class);
        $this->app->bind(IInventoryOrderRepository::class, InventoryOrderRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
