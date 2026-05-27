@extends('admin.layouts.master')

@section('title', 'نوع دسترسی و اشتراک - ' . $course->title)

@section('main')

<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 max-w-2xl">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $course->title }}</h2>
    <p class="text-gray-600 dark:text-gray-400 mb-6">تنظیم قیمت‌های اشتراک برای این دوره</p>

    @if($course->access_type === 'individual')
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-4 mb-6">
            <p class="text-blue-800 dark:text-blue-300">
                ℹ️ این دوره برای خرید تکی در نظر گرفته شده است. برای فعال‌سازی اشتراک، نوع دسترسی را در صفحه ویرایش دوره تغییر دهید.
            </p>
        </div>
    @elseif($course->access_type === 'subscription' || $course->access_type === 'both')
        <div class="space-y-4">
            @forelse($allPlans as $plan)
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 dark:text-white">{{ $plan->name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $plan->duration_days }} روز</p>
                        </div>
                        
                        @php
                            $coursePrice = $course->subscriptionPlans()
                                ->where('subscription_plan_id', $plan->id)
                                ->first();
                        @endphp

                        <div class="flex flex-wrap items-center gap-2">
                            <form action="{{ route('admin.subscription-plans.store-course-price', $course->id) }}"
                                method="POST" class="flex items-center gap-2">
                                @csrf
                                <input type="hidden" name="subscription_plan_id" value="{{ $plan->id }}">
                                <input 
                                    type="number" 
                                    name="price" 
                                    value="{{ $coursePrice ? $coursePrice->pivot->price : '' }}"
                                    placeholder="قیمت (تومان)"
                                    class="w-32 px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 outline-none"
                                    required
                                >
                                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition-colors">
                                    ذخیره
                                </button>
                            </form>

                            @if($coursePrice)
                                <form action="{{ route('admin.subscription-plans.remove-course-price', $course->id) }}"
                                    method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="subscription_plan_id" value="{{ $plan->id }}">
                                    <button type="submit" class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition-colors"
                                        onclick="return confirm('آیا مطمئن هستید؟')">
                                        حذف
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-600 dark:text-gray-400">هیچ پلانی موجود نیست</p>
            @endforelse
        </div>
    @endif

    <div class="flex items-center justify-start pt-6 border-t border-gray-200 dark:border-gray-700">
        <a href="{{ route('admin.courses.edit', $course->id) }}" 
            class="px-6 py-3 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all">
            بازگشت به دوره
        </a>
    </div>
</div>

@endsection
