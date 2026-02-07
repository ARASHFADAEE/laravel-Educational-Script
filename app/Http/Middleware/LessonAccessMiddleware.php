<?php

namespace App\Http\Middleware;

use App\Models\Chapter;
use App\Models\Enrollment;
use App\Models\Lesson;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LessonAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $UserId=Auth::id();
        $course=Lesson::query()
        ->where('slug','=',$request->slug)->select('chapter_id','is_free')
        ->first();
        $Chapter=Chapter::query()->where('id','=',$course->chapter_id)->firstOrFail();



        $HasAccsess=Enrollment::query()->where('user_id','=',$UserId)->where('course_id','=',$Chapter->course_id)->count();



        if($HasAccsess || $course->is_free ){

        return $next($request);

        }else{

        return redirect()->back()->with('error','برای دسترسی باید دوره را خریداری کنید');
        }

    }
}
