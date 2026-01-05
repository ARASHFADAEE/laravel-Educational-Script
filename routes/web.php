<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController as login;
use App\Http\Controllers\Auth\RegisterController as register;
use App\Http\Controllers\admin\dashboard as adminDashboard;
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
});

// Route::abort(404);