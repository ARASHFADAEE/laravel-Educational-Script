<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user\DashboardController;



Route::prefix('dashboard')->group(function(){

    Route::get('/',[DashboardController::class,'index'])->name("user.dashboard");

    Route::get('courses',[DashboardController::class,'Courses'])->name("user.courses");

    Route::get('/payments',[DashboardController::class,'payments'])->name("user.payments");

    Route::get('/profile',[DashboardController::class , 'profile'])->name('user.profile');



});
