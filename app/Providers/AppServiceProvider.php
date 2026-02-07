<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CourseCategory as category;
use App\Models\Enrollment;

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
         * send Count Cart Item  and course category Items In frontend
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
            'course_categories'=>$Course_categories_nav,
        
        ]);



    });


    /**
     * Send Data Dashbard Master User
     * @return View
     */

    view::composer('user.dashboard',function($view){


    $userId=Auth::id();
    $courses_user_count = Enrollment::where('user_id', $userId)->count();

        $view->with([
            'courses_user_count'=>$courses_user_count
        ]);


    });

    






    }
}
