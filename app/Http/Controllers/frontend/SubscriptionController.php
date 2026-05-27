<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\SubscriptionSettingController;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    /**
     * Show subscription plans page
     */
    public function index()
    {
        $plans = SubscriptionPlan::all();
        
        // Get prices from cache or settings
        $planPrices = [];
        foreach ($plans as $plan) {
            $planPrices[$plan->id] = SubscriptionSettingController::getPlanPrice($plan->slug);
        }

        return view('frontend.subscription-plans', compact('plans', 'planPrices'));
    }

    /**
     * Show checkout page for subscription
     */
    public function checkout(Request $request)
    {
        $planId = (int) $request->input('plan_id');
        $plan = SubscriptionPlan::findOrFail($planId);
        $price = SubscriptionSettingController::getPlanPrice($plan->slug);

        if ($price <= 0) {
            return redirect()->route('subscription.index')
                ->with('error', 'قیمت این پلن تنظیم نشده است.');
        }

        $userNameParts = Auth::check() ? explode(' ', trim(Auth::user()->name), 2) : ['', ''];
        $defaultFirstName = old('first_name', $userNameParts[0] ?? '');
        $defaultLastName = old('last_name', $userNameParts[1] ?? '');
        $defaultPhone = old('phone', Auth::check() ? Auth::user()->phone ?? '' : '');

        return view('frontend.subscription-checkout', compact('plan', 'price', 'defaultFirstName', 'defaultLastName', 'defaultPhone'));
    }
}
