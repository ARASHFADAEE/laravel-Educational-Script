@extends('admin.layouts.master')

@section('title', 'افزودن دوره')

@section('main')

<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 max-w-4xl">

    <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Title -->
        <div>
            <label class="form-label text-white">عنوان دوره</label>
            <input
                type="text"
                name="title"
                value="{{ old('title') }}"
                class="form-input w-full"
                placeholder="مثال: آموزش Laravel"
            >
            @error('title')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Slug -->
        <div>
            <label class="form-label text-white">اسلاگ</label>
            <input
                type="text"
                name="slug"
                value="{{ old('slug') }}"
                class="form-input w-full"
                placeholder="laravel-course"
            >
            @error('slug')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Category -->
        <div>
            <label class="form-label text-white">دسته‌بندی</label>
            <select name="category_id" class="form-input w-full">
                <option value="">انتخاب دسته‌بندی</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        @selected(old('category_id') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Level -->
        <div>
            <label class="form-label text-white">سطح دوره</label>
            <select name="level" class="form-input w-full">
                <option value="">انتخاب سطح</option>
                <option value="beginner" @selected(old('level')=='beginner')>مبتدی</option>
                <option value="intermediate" @selected(old('level')=='intermediate')>متوسط</option>
                <option value="advanced" @selected(old('level')=='advanced')>پیشرفته</option>
            </select>
            @error('level')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Price -->
        <div>
            <label class="form-label text-white">قیمت (تومان)</label>
            <input
                type="text"
                name="regular_price"
                value="{{ old('regular_price') }}"
                class="form-input w-full"
                placeholder="مثال: 1500000"
            >
            <label class="form-label text-white">قیمت با تخفیف (اختیاری)</label>
            <input
                type="text"
                name="sale_price"
                value="{{ old('sale_price') }}"
                class="form-input text-black w-full"
                placeholder="مثال: 1500000"
            >
            <label class="form-label text-white">تایم دوره به ساعت</label>
            <input
                type="time_course"
                name="time_course"
                value="{{ old('time_course') }}"
                class="form-input text-black w-full"
                placeholder="مثال: 5"
            >
            @error('time_course')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Status -->
        <div>
            <label class="form-label text-white">وضعیت</label>
            <select name="status" class="form-input text-black w-full">
                <option class="text-black" value="draft" @selected(old('status')=='draft')>پیش‌نویس</option>
                <option class="text-black" value="published" @selected(old('status')=='published')>منتشر شده</option>
            </select>
            @error('status')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Thumbnail -->
        <div>
            <label class="form-label text-white">تصویر دوره</label>
            <input
                type="file"
                name="thumbnail"
                class="form-input text-black w-full"
            >
            @error('thumbnail')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label class="form-label text-white">توضیحات دوره</label>
            <textarea
                name="description"
                rows="5"
                class="form-input text-black w-full"
                placeholder="توضیح کامل درباره دوره"
            >{{ old('description') }}</textarea>
            @error('description')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>


        <!-- Actions -->
        <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700 ">
            <a href="{{ route('admin.courses.index') }}" class="btn-secondary text-white">
                بازگشت
            </a>

            <button type="submit" class="text-white p-3 rounded" style="background: #2a77ff;">
                ذخیره دوره
            </button>
        </div>

    </form>

</div>

@endsection
