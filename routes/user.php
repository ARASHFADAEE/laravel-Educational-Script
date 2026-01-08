<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user\DashboardController;




Route::get('/dashboard',[DashboardController::class,'index']);