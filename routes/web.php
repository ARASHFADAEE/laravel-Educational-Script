<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController as login;
use App\Http\Controllers\Auth\RegisterController as register;
use App\Http\Controllers\admin\dashboard as adminDashboard;

use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\CourseController;
use App\Http\Controllers\admin\LessonController;
use App\Http\Controllers\admin\PaymentController;
use App\Http\Controllers\admin\PostCategoryController;
use App\Http\Controllers\admin\PostController;
use App\Http\Controllers\frontend\Homecontroller;
use App\Http\Controllers\frontend\SingleBlogController;
use App\Http\Controllers\admin\TinymceController;
use App\Http\Controllers\frontend\CommentController;
use App\Http\Controllers\frontend\CourseSingleController;
use App\Http\Controllers\frontend\CartController;
//Auth Routes
Route::prefix('auth')->middleware('guest')->group(function () {


Route::get('/login', [login::class,'show'])->name('auth.show');
Route::post('/login', [login::class,'submit'])->name('auth.login');
Route::get('/register',[register::class,'show'])->name('auth.register.show');
Route::post('/register',[register::class,'register'])->name('auth.register');

});


/**
 * Front End Route
 * 
 * @return Route
 */

//home and blog
Route::get('/',[Homecontroller::class,'index'])->name('home');
Route::get('/blog/{slug}',[SingleBlogController::class,'show'])->name('single.blog.show');

//Search Ajax
Route::get('/Search',[PostController::class,'search'])->name('search.ajax');

//logout
Route::post('/logout',[login::class,'logout'])->name('auth.logout');


//Render Comments for Single Blog Page
Route::get('/posts/{post}/comments', [CommentController::class, 'index'])->name('posts.comments');

//Comments Route
Route::middleware(['auth'])->group(function () {
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/comments/{comment}/like', [CommentController::class, 'like'])->name('comments.like');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::get('/comments/{comment}/replies', [CommentController::class, 'replies'])->name('comments.replies');

    //Cart Routes
    Route::get('/cart',[CartController::class,'index'])->name('cart.show');
});



//Single Course page
Route::get('/courses/{slug}',[CourseSingleController::class,'show'])->name('course.show');



//Cart System Route
Route::middleware(['auth'])->group(function () {
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove/{courseid}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
});







Route::prefix('admin')->middleware('admin')->group(function(){
    Route::get('/dashboard',[adminDashboard::class,'index'])->name('admin.dashboard');


    // Users Management
    Route::get('/users',[UserController::class,'index'])->name('admin.users.index');
    Route::get('/users/create',[UserController::class,'create'])->name('admin.users.create');
    Route::post('/users/store',[UserController::class,'store'])->name('admin.users.store');
    Route::get('/users/{id}/edit',[UserController::class,'edit'])->name('admin.users.edit');
    Route::put('/users/{id}',[UserController::class,'update'])->name('admin.users.update');
    Route::delete('/users/{id}',[UserController::class,'destroy'])->name('admin.users.destroy');


    // Course Categories Management
    Route::get('/course-categories',[App\Http\Controllers\admin\CourseCategoriesController::class,'index'])->name('admin.course_categories.index');
    Route::get('/course-categories/create',[App\Http\Controllers\admin\CourseCategoriesController::class,'create'])->name('admin.course_categories.create');
    Route::post('/course-categories/store',[App\Http\Controllers\admin\CourseCategoriesController::class,'store'])->name('admin.course_categories.store');
    Route::get('/course-categories/{id}/edit',[App\Http\Controllers\admin\CourseCategoriesController::class,'edit'])->name('admin.course_categories.edit');
    Route::put('/course-categories/{id}',[App\Http\Controllers\admin\CourseCategoriesController::class,'update'])->name('admin.course_categories.update');
    Route::delete('/course-categories/{id}',[App\Http\Controllers\admin\CourseCategoriesController::class,'destroy'])->name('admin.course_categories.destroy');

    //course Management Routes 
    Route::get('/courses',[CourseController::class,'index'])->name('admin.courses.index');
    Route::get('/courses/create',[CourseController::class,'create'])->name('admin.courses.create');
    Route::post('/courses/store',[CourseController::class,'store'])->name('admin.courses.store');
    Route::get('/courses/{id}/edit',[CourseController::class,'edit'])->name('admin.courses.edit');
    Route::put('/courses/{id}',[CourseController::class,'update'])->name('admin.courses.update');
    Route::delete('/courses/{id}',[CourseController::class,'destroy'])->name('admin.courses.destroy');

   //lesson  Management Routes 
   Route::get('/lessons',[LessonController::class,'index'])->name('admin.lessons.index');
   Route::get('/lessons/create',[LessonController::class,'create'])->name('admin.lessons.create');
   Route::post('/lessons/store',[LessonController::class,'store'])->name('admin.lessons.store');
   Route::get('/lessons/{id}/edit',[LessonController::class ,'edit'])->name('admin.lessons.edit');
   Route::put('/lessons/{id}/update',[LessonController::class,'update'])->name('admin.lessons.update');
   Route::delete('/lessons/{id}/delete',[LessonController::class,'destroy'])->name('admin.lessons.destroy');


    //Post Categories Management Routes 
    Route::get('/post-categories',[PostCategoryController::class,'index'])->name('admin.post.categories.index');
    Route::get('/post-category/create',[PostCategoryController::class , 'create'])->name('admin.post.category.create');
    Route::post('/post-category/create',[PostCategoryController::class , 'store'])->name('admin.post.category.store');
    Route::get('/post-category/{id}/edit',[PostCategoryController::class , 'edit'])->name('admin.post.category.edit');
    Route::put('/post-category/{id}/update',[PostCategoryController::class,'update'])->name('admin.post.category.update');
    Route::delete('/post-category/{id}/delete',[PostCategoryController::class,'destroy'])->name('admin.post.category.delete');
    Route::post('/upload-tinymce-image', [TinymceController::class, 'upload'])->name('tinymce.upload');



    //Post  Management Routes 
    Route::get('/posts/create',[PostController::class,'create'])->name('admin.post.create');
    Route::post('/posts/create',[PostController::class , 'store'])->name('admin.post.store');
    Route::get('/posts',[PostController::class,'index'])->name('admin.posts.index');
    Route::get('/posts/{id}/edit',[PostController::class,'edit'])->name('admin.post.edit');
    Route::post('/posts/update',[PostController::class,'update'])->name('admin.post.update');
    Route::delete('/posts/{id}/delete',[PostController::class,'destroy'])->name('admin.post.delete');




    //payment  Management Routes 

    Route::get('/payments',[PaymentController::class,'index'])->name('admin.payments.index');
    Route::get('/payments/create',[PaymentController::class,'create'])->name('admin.payments.create');
    Route::get('/payments/{id}/edit',[PaymentController::class,'edit'])->name('admin.payments.edit');
    Route::put('/payments/{id}/update',[PaymentController::class,'update'])->name('admin.payments.update');
    Route::post('/payments/store',[PaymentController::class,'store'])->name('admin.payments.store');
    Route::delete('/payments/{id}/delete',[PaymentController::class,'destroy'])->name('admin.payments.destroy');



    


});


