<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController as login;
use App\Http\Controllers\Auth\RegisterController as register;
use App\Http\Controllers\admin\dashboard as adminDashboard;

use App\Http\Controllers\admin\UserController;
use App\Models\User;

Route::get('/', function () {
    return view('frontend.index');
})->name('home');

//Auth Routes
Route::prefix('auth')->middleware('guest')->group(function () {

Route::get('/login', [login::class,'show'])->name('auth.show');
Route::post('/login', [login::class,'submit'])->name('auth.login');
Route::get('/register',[register::class,'show'])->name('auth.register.show');
Route::post('/register',[register::class,'register'])->name('auth.register');

});

Route::post('/logout',[login::class,'logout'])->name('auth.logout');








// Route::get('/admin',function(){
//     return view('admin.index');
// })->middleware('admin')->name('admin.dashboard');


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
});
// Route::abort(404);