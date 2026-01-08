<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\course_categorie as category;

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

        /**
         * send Count Cart Item  end course category Items In frontend
         * @return view
         */
        View::composer('frontend.layouts.master', function ($view) {

        $cart_count = 0;

        if (Auth::check()) {
            $cart_count = Cart::where('user_id', Auth::id())->count();
        }

        $Course_categories_nav=category::all();


        

        $view->with([
            'cart_count'=> $cart_count,
            'course_categories'=>$Course_categories_nav
        
        ]);
    });






    }
}
