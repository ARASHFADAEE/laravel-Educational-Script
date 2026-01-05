<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = course::orderBy('id', 'desc')->paginate(10);
        return view('admin.courses.index', compact('courses'));
    }
}
