<?php

namespace App\Http\Middleware;

use App\Models\Chapter;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Course;
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
        $lesson=Lesson::query()
        ->where('slug','=',$request->slug)->select('chapter_id','is_free')
        ->firstOrFail();
        $Chapter=Chapter::query()->where('id','=',$lesson->chapter_id)->firstOrFail();
        $course = Course::findOrFail($Chapter->course_id);



        $HasAccsess=Enrollment::query()->where('user_id','=',$UserId)->where('course_id','=',$Chapter->course_id)->count();

        $hasActiveSubscription = Auth::check()
            && in_array($course->access_type, ['subscription', 'both'])
            && Auth::user()
                ->subscriptions()
                ->where('status', 'active')
                ->where('end_date', '>', now())
                ->exists();

        if($HasAccsess || $hasActiveSubscription || $lesson->is_free ){

        return $next($request);

        }else{

        return redirect()->back()->with('error','برای دسترسی باید دوره را خریداری کنید');
        }

    }
}
