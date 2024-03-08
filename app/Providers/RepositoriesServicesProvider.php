<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Interface
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\WishlistBookRepositoryInterface;
use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\Interfaces\BookDetailRepositoryInterface;
use App\Repositories\Interfaces\PaymentBookRepositoryInterface;
use App\Repositories\Interfaces\OrderDetailRepositoryInterface;
use App\Repositories\Interfaces\OrderDescripitionRepositoryInterface;
use App\Repositories\Interfaces\ShippingDetailRepositoryInterface;


// Repositories
use App\Repositories\UserRepository;
use App\Repositories\WishlistBookRepository;
use App\Repositories\CartRepository;
use App\Repositories\BookDetailRepository;
use App\Repositories\PaymentBookRepository;
use App\Repositories\OrderDetailRepository;
use App\Repositories\OrderDescripitionRepository;
use App\Repositories\ShippingDetailRepository;

class RepositoriesServicesProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class,UserRepository::class);
        $this->app->bind(WishlistBookRepositoryInterface::class,WishlistBookRepository::class);
        $this->app->bind(CartRepositoryInterface::class,CartRepository::class);
        $this->app->bind(BookDetailRepositoryInterface::class,BookDetailRepository::class);
        $this->app->bind(PaymentBookRepositoryInterface::class,PaymentBookRepository::class);
        $this->app->bind(OrderDetailRepositoryInterface::class,OrderDetailRepository::class);
        $this->app->bind(OrderDescripitionRepositoryInterface::class,OrderDescripitionRepository::class);
        $this->app->bind(ShippingDetailRepositoryInterface::class,ShippingDetailRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
