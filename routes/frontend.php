<?php

use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController as login;
use App\Http\Controllers\Auth\RegisterController as register;
use App\Http\Controllers\Frontend\CommentController;
use App\Http\Controllers\Frontend\CourseSingleController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\SingleBlogController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



//use Post Controller For Ajax Search
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Frontend\ArchiveCourseController;

//Auth Routes
Route::prefix('auth')->middleware('guest')->group(function () {
    Route::get('/login', [login::class, 'show'])->name('auth.show');
    Route::post('/login', [login::class, 'submit'])->name('auth.login');
    Route::get('/register', [register::class, 'show'])->name('auth.register.show');
    Route::post('/register', [register::class, 'register'])->name('auth.register');
});




/**
 * Front End Route
 *
 * @return Route
 */

//home and blog
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/blog/{slug}', [SingleBlogController::class, 'show'])->name('single.blog.show');

//Search Ajax
Route::get('/Search', [PostController::class, 'search'])->name('search.ajax');

//logout
Route::post('/logout', [login::class, 'logout'])->name('auth.logout');


//Render Comments for Single Blog Page
Route::get('/posts/{post}/comments', [CommentController::class, 'index'])->name('posts.comments');

//Comments Route
Route::middleware(['user'])->group(function () {
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/comments/{comment}/like', [CommentController::class, 'like'])->name('comments.like');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::get('/comments/{comment}/replies', [CommentController::class, 'replies'])->name('comments.replies');

    //Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.show');
});



//Single Course page
Route::get('/courses/{slug}', [CourseSingleController::class, 'show'])->name('course.show');



//Cart System Route
Route::middleware(['user'])->group(function () {
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove/{courseid}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');


    Route::post('/pay/zibal', [PaymentController::class, 'request_zibal'])->name('pay.zibal');
    Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');


    //show episodes

});



//Archive Courses Route


Route::get('/courses',[ArchiveCourseController::class,'index'])->name('courses.show');

Route::get('/course-cat/{slug}',[ArchiveCourseController::class,'ShowCategory'])->name('show.courses.category');




Route::get('/Setting',[SettingController::class,'index'])->name('setting.index');
