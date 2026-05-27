@extends('admin.layouts.master')

@section('title', 'تنظیمات اشتراک')

@section('main')

<div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">تنظیمات قیمت اشتراک</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-1">تنظیم قیمت هر پلن اشتراک</p>
    </div>

    <form action="{{ route('admin.subscription-settings.update') }}" method="POST" class="p-6 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($plans as $plan)
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $plan->name }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                {{ $plan->duration_days }} روز دسترسی
                            </p>
                        </div>
                        <div class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                            <span class="text-sm font-medium text-blue-800 dark:text-blue-300">
                                پلن {{ $loop->iteration }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                قیمت (تومان)
                            </label>
                            <div class="flex items-center gap-2">
                                <input 
                                    type="number" 
                                    name="prices[{{ $plan->id }}]" 
                                    value="{{ \App\Http\Controllers\Admin\SubscriptionSettingController::getPlanPrice($plan->slug) }}"
                                    min="0"
                                    step="1000"
                                    class="flex-1 px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 outline-none"
                                    placeholder="مثال: 50000"
                                >
                                <span class="text-sm text-gray-500 dark:text-gray-400">ت</span>
                            </div>
                            @error('prices.' . $plan->id)
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-3">
                            <p class="text-sm text-blue-800 dark:text-blue-300">
                                ℹ️ این قیمت برای تمام دوره‌های اشتراک‌پذیر (نوع دسترسی = اشتراک یا هر دو) استفاده می‌شود.
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 rounded-lg p-4">
            <h4 class="font-medium text-amber-900 dark:text-amber-300 mb-2">⚠️ توجه:</h4>
            <ul class="list-disc list-inside text-sm text-amber-800 dark:text-amber-200 space-y-1">
                <li>قیمت‌ها برای تمام دوره‌هایی که نوع دسترسی آن‌ها "اشتراک" یا "هر دو" است استفاده می‌شود.</li>
                <li>برای تنظیم قیمت مخصوص یک دوره، از صفحه ویرایش دوره استفاده کنید.</li>
                <li>تغییرات بلافاصله اعمال می‌شوند.</li>
            </ul>
        </div>

        <div class="flex items-center gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('admin.dashboard') }}" 
                class="px-6 py-3 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                بازگشت
            </a>
            <button type="submit" class="ml-auto px-8 py-3 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-medium transition-colors">
                ذخیره تغییرات
            </button>
        </div>
    </form>
</div>

@endsection
