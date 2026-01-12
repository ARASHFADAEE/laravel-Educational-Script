<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use Illuminate\Http\Request;
use App\Models\course;
use App\Models\lesson;
use App\Models\payment;
use Illuminate\Support\Facades\Auth;



class CourseSingleController extends Controller
{


    /**
     * show Course Single Page with slug
     *
     * @return view
     */

    public function show($slug){


        /**
         * Query Slug and Send Data to view
         *
         * @return object
         */
        $course=Course::query()->where('slug','=',$slug)->with(['user:id,name,avatar,bio'])->first();
        $lesson_one=lesson::query()->where('chapter_id','=',$course->chapters()->first()->id)->first();
        $chapters=chapter::query()->where('course_id','=',$course->id)->withCount('lessons')->get();
        $has_accsess=payment::query()->where('user_id','=',Auth::id())->where('course_id',$course->id)->first();


        return view('frontend.SingleCourse',compact('course','lesson_one','has_accsess','chapters'));

    }
}
