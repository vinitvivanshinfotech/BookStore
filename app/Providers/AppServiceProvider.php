<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // view()->composer('User.userLayout.layout', function ($view) {
        //     $view->with('cartCount',  Cart::where('user_id',auth()->user()?->id)->count());
        // });
    }
}
