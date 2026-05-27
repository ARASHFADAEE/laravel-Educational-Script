<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionSettingController extends Controller
{
    /**
     * Show subscription settings page
     */
    public function index()
    {
        $plans = SubscriptionPlan::all();

        return view('admin.subscription_settings.index', compact('plans'));
    }

    /**
     * Update subscription prices
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'prices' => 'required|array',
            'prices.*' => 'numeric|min:0',
        ]);

        // Update prices for each plan
        foreach ($validated['prices'] as $planId => $price) {
            $plan = SubscriptionPlan::findOrFail($planId);

            Setting::updateOrCreate(
                ['key' => self::priceSettingKey($plan->slug)],
                ['value' => (string) (int) $price]
            );
        }

        return redirect()->route('admin.subscription-settings.index')
            ->with('success', 'قیمت اشتراک‌ها به‌روزرسانی شدند.');
    }

    /**
     * Get subscription plan price (helper)
     */
    public static function getPlanPrice($planSlug)
    {
        return (int) Setting::where('key', self::priceSettingKey($planSlug))->value('value');
    }

    public static function priceSettingKey(string $planSlug): string
    {
        return 'subscription_plan_' . $planSlug . '_price';
    }
}
