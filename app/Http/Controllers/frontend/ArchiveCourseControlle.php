<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\course;
use Illuminate\Http\Request;

class ArchiveCourseControlle extends Controller
{
    /**
     * view All Courses Archive
     * @return view
     */

    public function index(){

        $courses=course::query()->withCount('lessons')->latest()->paginate(10);

        return view('frontend.ArchiveCourses',compact('courses'));
    }
}
