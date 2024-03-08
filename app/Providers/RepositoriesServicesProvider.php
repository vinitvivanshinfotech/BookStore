<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Interface
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\WishlistBookRepositoryInterface;
use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\Interfaces\BookDetailRepositoryInterface;


// Repositories
use App\Repositories\UserRepository;
use App\Repositories\WishlistBookRepository;
use App\Repositories\CartRepository;
use App\Repositories\BookDetailRepository;

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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
