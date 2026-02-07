<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Enrollment;
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
        $lesson_one=Lesson::query()->where('chapter_id','=',$course->chapters()->first()->id)->first();
        $chapters=Chapter::query()->where('course_id','=',$course->id)->withCount('lessons')->get();

        $has_accsess = false;
        if(Auth::check()){
            $has_accsess = Enrollment::where('user_id', Auth::id())
                ->where('course_id', $course->id)
                ->exists();
        }


        return view('frontend.SingleCourse',compact('course','lesson_one','has_accsess','chapters'));

    }
}
