<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController as adminDashboard;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PostCategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\TinymceController;



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
    Route::get('/course-categories',[App\Http\Controllers\Admin\CourseCategoriesController::class,'index'])->name('admin.course_categories.index');
    Route::get('/course-categories/create',[App\Http\Controllers\Admin\CourseCategoriesController::class,'create'])->name('admin.course_categories.create');
    Route::post('/course-categories/store',[App\Http\Controllers\Admin\CourseCategoriesController::class,'store'])->name('admin.course_categories.store');
    Route::get('/course-categories/{id}/edit',[App\Http\Controllers\Admin\CourseCategoriesController::class,'edit'])->name('admin.course_categories.edit');
    Route::put('/course-categories/{id}',[App\Http\Controllers\Admin\CourseCategoriesController::class,'update'])->name('admin.course_categories.update');
    Route::delete('/course-categories/{id}',[App\Http\Controllers\Admin\CourseCategoriesController::class,'destroy'])->name('admin.course_categories.destroy');

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
