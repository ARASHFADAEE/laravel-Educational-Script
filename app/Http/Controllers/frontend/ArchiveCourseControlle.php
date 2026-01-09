<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArchiveCourseControlle extends Controller
{
    /**
     * view All Courses Archive
     * @return view
     */

    public function index(){
        return view('frontend.ArchiveCourses');
    }
}
