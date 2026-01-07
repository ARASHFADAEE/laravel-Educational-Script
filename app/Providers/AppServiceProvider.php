<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
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
        View::composer('frontend.layouts.master', function ($view) {

        $cart_count = 0;

        if (Auth::check()) {
            $cart_count = Cart::where('user_id', Auth::id())->count();
        }

        $view->with('cart_count', $cart_count);
    });
    }
}
