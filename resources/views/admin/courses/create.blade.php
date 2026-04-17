@extends('admin.layouts.master')

@section('title', 'افزودن دوره')

@section('main')

<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 max-w-4xl">

    <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Title -->
        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">عنوان دوره</label>
            <input
                type="text"
                name="title"
                value="{{ old('title') }}"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none"
                placeholder="مثال: آموزش Laravel"
            >
            @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Slug -->
        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">اسلاگ</label>
            <input
                type="text"
                name="slug"
                value="{{ old('slug') }}"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none"
                placeholder="laravel-course"
            >
            @error('slug')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Category -->
        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">دسته‌بندی</label>
            <select name="category_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none appearance-none">
                <option value="">انتخاب دسته‌بندی</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        @selected(old('category_id') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Level -->
        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">سطح دوره</label>
            <select name="level" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none appearance-none">
                <option value="">انتخاب سطح</option>
                <option value="beginner" @selected(old('level')=='beginner')>مبتدی</option>
                <option value="intermediate" @selected(old('level')=='intermediate')>متوسط</option>
                <option value="advanced" @selected(old('level')=='advanced')>پیشرفته</option>
            </select>
            @error('level')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Price -->
        <div class="grid md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">قیمت (تومان)</label>
                <input
                    type="text"
                    name="regular_price"
                    value="{{ old('regular_price') }}"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none"
                    placeholder="مثال: 1500000"
                >
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">قیمت با تخفیف (اختیاری)</label>
                <input
                    type="text"
                    name="sale_price"
                    value="{{ old('sale_price') }}"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none"
                    placeholder="مثال: 1500000"
                >
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">تایم دوره به ساعت</label>
                <input
                    type="text"
                    name="time_course"
                    value="{{ old('time_course') }}"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none"
                    placeholder="مثال: 5"
                >
                @error('time_course')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Status & Thumbnail -->
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">وضعیت</label>
                <select name="status" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none appearance-none">
                    <option value="draft" @selected(old('status')=='draft')>پیش‌نویس</option>
                    <option value="published" @selected(old('status')=='published')>منتشر شده</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">تصویر دوره</label>
                <input
                    type="file"
                    name="thumbnail"
                    class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-300"
                >
                @error('thumbnail')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Description -->
        <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">توضیحات دوره</label>
            <textarea
                name="description"
                rows="5"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none"
                placeholder="توضیح کامل درباره دوره"
            >{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>


        <!-- Actions -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('admin.courses.index') }}" class="px-6 py-3 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all">
                بازگشت
            </a>

            <button type="submit" class="px-8 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold shadow-lg shadow-indigo-500/20 transition-all hover:scale-[1.02] active:scale-[0.98]">
                ذخیره دوره
            </button>
        </div>
    </form>
</div>

@endsection
