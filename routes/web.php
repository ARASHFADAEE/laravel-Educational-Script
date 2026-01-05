<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController as login;
Route::get('/', function () {
    return view('frontend.index');
});


Route::get('/login', [login::class,'show'])->name('auth.show');
Route::post('/login', [login::class,'submit'])->name('auth.login');




Route::get('/admin',function(){
    return view('admin.index');
});


// Route::abort(404);