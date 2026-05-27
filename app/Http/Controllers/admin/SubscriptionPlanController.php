<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubscriptionPlanController extends Controller
{
    /**
     * Display subscription plans
     */
    public function index()
    {
        $plans = SubscriptionPlan::all();
        return view('admin.subscription_plans.index', compact('plans'));
    }

    /**
     * Show edit form for subscription plan
     */
    public function edit($id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        return view('admin.subscription_plans.edit', compact('plan'));
    }

    /**
     * Update subscription plan
     */
    public function update(Request $request, $id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('subscription_plans', 'slug')->ignore($plan->id),
            ],
            'duration_days' => 'required|integer|min:1|max:3650',
            'description' => 'nullable|string|max:1000',
        ]);

        $plan->update($validated);
        
        return redirect()->route('admin.subscription-plans.index')->with('success', 'پلان اشتراک به‌روزرسانی شد.');
    }

    /**
     * Show course subscription plan management
     */
    public function coursePlans($courseId)
    {
        $course = \App\Models\Course::findOrFail($courseId);
        $allPlans = SubscriptionPlan::all();
        $coursePlans = $course->subscriptionPlans;
        
        return view('admin.subscription_plans.course_plans', compact('course', 'allPlans', 'coursePlans'));
    }

    /**
     * Store or update course subscription plan price
     */
    public function storeCoursePrice(Request $request, $courseId)
    {
        $course = \App\Models\Course::findOrFail($courseId);
        
        $validated = $request->validate([
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'price' => 'required|numeric|min:0',
        ]);

        $course->subscriptionPlans()->syncWithoutDetaching([
            $validated['subscription_plan_id'] => ['price' => $validated['price']]
        ]);

        return back()->with('success', 'قیمت اشتراک ذخیره شد.');
    }

    /**
     * Remove course subscription plan
     */
    public function removeCoursePrice(Request $request, $courseId)
    {
        $course = \App\Models\Course::findOrFail($courseId);
        
        $validated = $request->validate([
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
        ]);

        $course->subscriptionPlans()->detach($validated['subscription_plan_id']);

        return back()->with('success', 'پلان اشتراک حذف شد.');
    }
}
