@extends('admin.layouts.master')

@section('title', 'افزودن سرفصل')

@section('main')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 max-w-3xl">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">ایجاد سرفصل جدید</h3>

    <form action="{{ route('admin.chapters.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">دوره <span class="text-red-500">*</span></label>
            <select name="course_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                <option value="">انتخاب دوره</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                        {{ $course->title }}
                    </option>
                @endforeach
            </select>
            @error('course_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">عنوان سرفصل <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="مثلا: مقدمات لاراول" required>
            @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">توضیحات</label>
            <textarea name="description" rows="4" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="توضیحات این سرفصل (اختیاری)">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">ترتیب نمایش</label>
            <input type="number" name="position" value="{{ old('position', 0) }}" min="0" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            @error('position')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('admin.chapters.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 dark:border-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                بازگشت
            </a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                ذخیره سرفصل
            </button>
        </div>
    </form>
</div>
@endsection
