@extends('admin.layouts.master')

@section('title', 'ویرایش دوره')

@section('main')

<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 max-w-4xl">

    <form action="{{ route('admin.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div>
            <label class="form-label">عنوان دوره</label>
            <input
                type="text"
                name="title"
                value="{{ old('title', $course->title) }}"
                class="form-input text-black w-full"
                placeholder="مثال: آموزش Laravel"
            >
            @error('title')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Slug -->
        <div>
            <label class="form-label">اسلاگ</label>
            <input
                type="text"
                name="slug"
                value="{{ old('slug', $course->slug) }}"
                class="form-input text-black w-full"
                placeholder="laravel-course"
            >
            @error('slug')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Category -->
        <div>
            <label class="form-label">دسته‌بندی</label>
            <select name="category_id" class="form-input text-black w-full">
                <option value="">انتخاب دسته‌بندی</option>
                @foreach($categories as $category)
                    <option class="text-black" value="{{ $category->id }}"
                        @selected(old('category_id', $course->category_id) == $category->id)>
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
            <label class="form-label">سطح دوره</label>
            <select name="level" class="form-input text-black w-full">
                <option class="text-black" value="">انتخاب سطح</option>
                <option class="text-black" value="beginner" @selected(old('level', $course->level) == 'beginner')>مبتدی</option>
                <option class="text-black" value="intermediate" @selected(old('level', $course->level) == 'intermediate')>متوسط</option>
                <option class="text-black" value="advanced" @selected(old('level', $course->level) == 'advanced')>پیشرفته</option>
            </select>
            @error('level')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Price -->
        <div>
            <label class="form-label">قیمت اصلی( به تومان)</label>
            <input
                type="text"
                name="regular_price"
                value="{{ old('regular_price', $course->regular_price) }}"
                class="form-input text-black w-full"
                placeholder="مثال: 1500000"
            >
            @error('regular_price')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>
           <div>
            <label class="form-label">قیمت با تخفیف (اختیاری)</label>
            <input
                type="text"
                name="sale_price"
                value="{{ old('sale_price', $course->sale_price) }}"
                class="form-input text-black w-full"
                placeholder="مثال: 1500000"
            >
            @error('regular_price')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>
                   <div>
            <label class="form-label">مدت زمان دوره (به ساعت)</label>
            <input
                type="text"
                name="time_course"
                value="{{ old('time_course', $course->time_course) }}"
                class="form-input text-black w-full"
                placeholder="مثال: 1500000"
            >
            @error('time_course')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Status -->
        <div>
            <label class="form-label ">وضعیت</label>
            <select name="status" class="form-input text-black w-full">
                <option class="text-black" value="draft" @selected(old('status', $course->status) == 'draft')>پیش‌نویس</option>
                <option class="text-black" value="published" @selected(old('status', $course->status) == 'published')>منتشر شده</option>
            </select>
            @error('status')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Thumbnail -->
        <div>
            <label class="form-label">تصویر دوره</label>
            @if($course->thumbnail)
                <div class="mb-3">
                    <p class="text-sm text-gray-600 dark:text-gray-400">تصویر فعلی:</p>
                    <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="Thumbnail" class="h-48 rounded-lg object-cover">
                </div>
            @endif
            <input
                type="file"
                name="thumbnail"
                class="form-input  w-full"
                accept="image/*"
            >
            <p class="text-sm text-gray-500 mt-1">در صورت عدم انتخاب فایل، تصویر فعلی حفظ می‌شود.</p>
            @error('thumbnail')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label class="form-label">توضیحات دوره</label>
            <textarea
                name="description"
                rows="5"
                class="form-input text-black w-full"
                placeholder="توضیح کامل درباره دوره"
            >{{ old('description', $course->description) }}</textarea>
            @error('description')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('admin.courses.index') }}" class="btn-secondary">
                بازگشت
            </a>

            <button type="submit" class="text-white px-6 py-3 rounded" style="background: #2a77ff;">
                ذخیره تغییرات
            </button>
        </div>

    </form>

</div>

@endsection