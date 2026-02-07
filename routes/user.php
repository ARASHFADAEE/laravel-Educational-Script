<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\UserProfileController;


use App\Http\Controllers\Frontend\LessonController;

//Start User Panel Route

Route::prefix('dashboard')->middleware(['auth'])->group(function () {


    Route::get('/',[DashboardController::class,'index'])->name("user.dashboard");

    Route::get('courses',[DashboardController::class,'Courses'])->name("user.courses");

    Route::get('/payments',[DashboardController::class,'payments'])->name("user.payments");



    // پروفایل کاربر
    Route::get('/profile', [UserProfileController::class, 'profile'])->name('user.profile');

    // بروزرسانی اطلاعات
    Route::put('/profile', [UserProfileController::class, 'updateProfile'])->name('user.profile.update');

    // بروزرسانی رمز عبور
    Route::put('/profile/password', [UserProfileController::class, 'updatePassword'])->name('user.password.update');

    // حذف آواتار
    Route::delete('/profile/avatar', [UserProfileController::class, 'deleteAvatar'])->name('user.avatar.delete');

    // API endpoints
    Route::get('/profile/data', [UserProfileController::class, 'getProfileData'])->name('user.profile.data');
    Route::post('/profile/validate-password', [UserProfileController::class, 'validateCurrentPassword'])->name('user.validate.password');

    // نوتیفیکیشن‌ها
    Route::put('/profile/notifications', [UserProfileController::class, 'updateNotifications'])->name('user.notifications.update');





});

//Lesson Route Show
Route::middleware(['user'])->middleware('LessonAccess')->group(function () {
    Route::get('/lesson/{slug}',[LessonController::class,'index'])->name('lesson.show');

});

