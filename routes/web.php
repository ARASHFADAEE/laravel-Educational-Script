<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController as login;
use App\Http\Controllers\Auth\RegisterController as register;
Route::get('/', function () {
    return view('frontend.index');
})->name('home');

//Auth
Route::get('/login', [login::class,'show'])->name('auth.show');
Route::post('/login', [login::class,'submit'])->name('auth.login');

Route::get('/register',[register::class,'show'])->name('auth.register.show');
Route::post('/register',[register::class,'register'])->name('auth.register');






Route::get('/admin',function(){
    return view('admin.index');
});


// Route::abort(404);