<?php

namespace App\Http\Middleware;

use App\Models\enrollment;
use App\Models\lesson;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\payment;

class LessonacsessMiddalware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $UserId=Auth::id();
        $course=lesson::query()
        ->where('slug','=',$request->slug)->select('course_id','is_free')
        ->first();



        $HasAccsess=enrollment::query()->where('user_id','=',$UserId)->where('course_id','=',$course->course_id)->count();

         

        if($HasAccsess || $course->is_free ){

        return $next($request);
        
        }else{

        return redirect()->back()->with('error','برای دسترسی باید دوره را خریداری کنید');
        }

    }
}
