<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\SubscriptionSettingController;
use App\Models\Chapter;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Enrollment;
use App\Models\SubscriptionPlan;
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
        $course = Course::query()
            ->where('slug', $slug)
            ->with(['user:id,name,avatar,bio', 'subscriptionPlans'])
            ->firstOrFail();

        $chapters = Chapter::query()
            ->where('course_id', $course->id)
            ->with('lessons')
            ->orderBy('position', 'asc')
            ->get();

        $lessons_count = 0;
        $lesson_one = null;

        foreach ($chapters as $chapter) {
            $lessons_count += $chapter->lessons->count();
            if (!$lesson_one && $chapter->lessons->isNotEmpty()) {
                $lesson_one = $chapter->lessons->sortBy('position')->first();
            }
        }

        $students_count = Enrollment::where('course_id', $course->id)->count();
        $subscriptionPlansForCheckout = collect();

        if (in_array($course->access_type, ['subscription', 'both'])) {
            $coursePlanPrices = $course->subscriptionPlans->keyBy('id');

            $subscriptionPlansForCheckout = SubscriptionPlan::all()
                ->map(function (SubscriptionPlan $plan) use ($coursePlanPrices) {
                    $coursePlan = $coursePlanPrices->get($plan->id);
                    $price = $coursePlan ? (int) $coursePlan->pivot->price : SubscriptionSettingController::getPlanPrice($plan->slug);

                    if ($price <= 0) {
                        return null;
                    }

                    $plan->checkout_price = $price;
                    return $plan;
                })
                ->filter()
                ->values();
        }

        $has_access = false;
        $in_cart = false;
        if(Auth::check()){
            $has_access = Enrollment::where('user_id', Auth::id())
                ->where('course_id', $course->id)
                ->exists();

            if (!$has_access && in_array($course->access_type, ['subscription', 'both'])) {
                $has_access = Auth::user()
                    ->subscriptions()
                    ->where('status', 'active')
                    ->where('end_date', '>', now())
                    ->exists();
            }

            $in_cart = \App\Models\Cart::where('user_id', Auth::id())
                ->where('course_id', $course->id)
                ->exists();
        }


        return view('frontend.SingleCourse',compact('course','lesson_one','has_access','in_cart','chapters', 'lessons_count', 'students_count', 'subscriptionPlansForCheckout'));

    }
}
