@extends('admin.layouts.master')

@section('title', 'مدیریت پلان‌های اشتراک')

@section('main')

<div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">پلان‌های اشتراک</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-1">مدیریت پلان‌های اشتراک ماهانه و سه‌ماهه</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                <tr>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-900 dark:text-white">نام پلان</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-900 dark:text-white">مدت زمان</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-900 dark:text-white">توضیحات</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900 dark:text-white">عملیات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($plans as $plan)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="text-gray-900 dark:text-white font-medium">{{ $plan->name }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                                {{ $plan->duration_days }} روز
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                            {{ $plan->description ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.subscription-plans.edit', $plan->id) }}" 
                                    class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium transition-colors">
                                    ویرایش
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                            هیچ پلانی وجود ندارد
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<p class="text-sm text-gray-600 dark:text-gray-400 mt-4">
    💡 برای تنظیم قیمت اشتراک برای دوره‌های خاص، از صفحه ویرایش دوره استفاده کنید.
</p>

@endsection
