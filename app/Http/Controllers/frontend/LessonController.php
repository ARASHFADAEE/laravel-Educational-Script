<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Course;
use App\Models\lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{

    /**
     * Show Index Episodes
     *
     * @return view
    */
    public function index($slug){

        $lesson=lesson::query()->where('slug',$slug)->with('chapter')->first();
        $course=Course::query()->where('id',$lesson->chapter->course_id)->first();
        $chapters=Chapter::query()->where('course_id',$course->id)->with('lessons')->get();






        return view('frontend.ShowEpisodes',compact('lesson','course','chapters'));

    }

}
