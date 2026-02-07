<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{

    /**
     * Show Index Episodes
     *
     * @return view
    */
    public function index($slug){

        $lesson=Lesson::query()->where('slug',$slug)->with('chapter')->first();
        $course=Course::query()->where('id',$lesson->chapter->course_id)->first();
        $chapters=Chapter::query()->where('course_id',$course->id)->with('lessons')->get();






        return view('frontend.ShowEpisodes',compact('lesson','course','chapters'));

    }

}
