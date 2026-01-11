<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
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

        $lesson=lesson::query()->where('slug','=',$slug)->with('course')->first();

        $lessons=Lesson::query()->where('course_id','=',$lesson->course->id)->get();

        return view('frontend.ShowEpisodes',compact('lesson','lessons'));

    }

}
