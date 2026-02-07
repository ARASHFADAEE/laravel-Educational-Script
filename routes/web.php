<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\ArchiveCourseController;




//Front End Route
require __DIR__.'/frontend.php';

//Admin Route
require __DIR__.'/admin.php';

//User Route
require __DIR__.'/user.php';



//Ajax Data Archive Course
Route::get('/search/ajax',[ArchiveCourseController::class,'search'])->name('search.ajax');
Route::get('/category/ajax',[ArchiveCourseController::class,'category_ajax'])->name('category.ajax');





Route::get('/course/ajax',[App\Http\Controllers\Admin\LessonController::class,'course_ajax'])->middleware('admin')->name('course.ajax.admin');














