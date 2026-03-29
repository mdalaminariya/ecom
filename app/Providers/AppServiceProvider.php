<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

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
        Paginator::useBootstrapFive();

        // Share cart data with all views
       View::composer('*', function ($view) {
    $cartItems = collect();
    $cartCount = 0;
    $cartTotal = 0;

    if (Auth::check()) {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $cartCount = $cartItems->sum('quantity');

     $cartTotal = $cartItems->sum(function($item) {
    return $item->product->price * $item->quantity;
});
    }

    $view->with(compact('cartItems', 'cartCount', 'cartTotal'));
});
    }
}
