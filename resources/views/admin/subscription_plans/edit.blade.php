@extends('admin.layouts.master')

@section('title', 'ویرایش پلن اشتراک')

@section('main')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 max-w-2xl mx-auto">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">ویرایش پلن اشتراک</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-1">مشخصات پایه پلن را ویرایش کنید.</p>
    </div>

    <form action="{{ route('admin.subscription-plans.update', $plan->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                نام پلن <span class="text-red-500">*</span>
            </label>
            <input type="text" name="name" value="{{ old('name', $plan->name) }}"
                class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                placeholder="مثلا: اشتراک ماهانه" required>
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                اسلاگ <span class="text-red-500">*</span>
            </label>
            <input type="text" name="slug" value="{{ old('slug', $plan->slug) }}"
                class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                placeholder="monthly" pattern="[a-z0-9\-]+" required>
            @error('slug')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                مدت دسترسی، روز <span class="text-red-500">*</span>
            </label>
            <input type="number" name="duration_days" value="{{ old('duration_days', $plan->duration_days) }}"
                min="1"
                class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                required>
            @error('duration_days')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                توضیحات
            </label>
            <textarea name="description" rows="4"
                class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                placeholder="توضیح کوتاه برای این پلن">{{ old('description', $plan->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('admin.subscription-plans.index') }}"
                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 dark:border-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                بازگشت
            </a>
            <button type="submit"
                class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                ذخیره تغییرات
            </button>
        </div>
    </form>
</div>
@endsection
