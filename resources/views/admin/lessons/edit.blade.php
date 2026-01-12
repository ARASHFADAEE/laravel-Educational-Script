@extends('admin.layouts.master')

@section('title', 'ویرایش درس')

@section('main')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">ویرایش درس: {{ $lesson->title }}</h2>

    <form action="{{ route('admin.lessons.update', $lesson->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- عنوان -->
        <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                عنوان درس <span class="text-red-500">*</span>
            </label>
            <input type="text"
                   name="title"
                   value="{{ old('title', $lesson->title) }}"
                   class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                   placeholder="عنوان درس"
                   required>
            @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- دوره -->
        <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                دوره <span class="text-red-500">*</span>
            </label>
            <select name="chapter_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                @foreach($chapters as $chapter)
                    <option value="{{ $chapter->id }}" {{ old('chapter_id', $chapter->course_id) == $chapter->id ? 'selected' : '' }}>
                        {{ $chapter->title }}
                    </option>
                @endforeach
            </select>
            @error('course_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- اسلاگ -->
        <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                اسلاگ <span class="text-red-500">*</span>
                <span class="text-xs text-gray-500">(فقط حروف انگلیسی، اعداد و خط‌تیره)</span>
            </label>
            <input type="text"
                   name="slug"
                   value="{{ old('slug', $lesson->slug) }}"
                   class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                   placeholder="example-lesson-slug"
                   pattern="[a-z0-9\-]+"
                   required>
            @error('slug')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- محتوا -->
        <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                محتوای درس
            </label>
            <textarea name="content"
                      id="content"
                      rows="10"
                      class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                      placeholder="محتوای کامل درس...">{{ old('content', $lesson->content) }}</textarea>
            @error('content')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- لینک ویدیو -->
        <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                لینک ویدیو
            </label>
            <input type="url"
                   name="video_url"
                   value="{{ old('video_url', $lesson->video_url) }}"
                   class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                   placeholder="https://example.com/video.mp4">
            @error('video_url')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- موقعیت -->
        <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                موقعیت نمایش
            </label>
            <input type="number"
                   name="position"
                   value="{{ old('position', $lesson->position) }}"
                   min="0"
                   class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                   placeholder="ترتیب نمایش درس">
            <p class="text-xs text-gray-500 mt-1">اعداد کمتر ابتدا نمایش داده می‌شوند</p>
            @error('position')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- وضعیت رایگان/پولی -->
        <div class="flex items-center">
            <input type="checkbox"
                   name="is_free"
                   id="is_free"
                   value="1"
                   {{ old('is_free', $lesson->is_free) ? 'checked' : '' }}
                   class="h-4 w-4 text-blue-600 rounded">
            <label for="is_free" class="mr-2 text-sm text-gray-700 dark:text-gray-300">
                این درس رایگان است
            </label>
            @error('is_free')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- اطلاعات اضافی -->
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mt-6">
            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">اطلاعات تکمیلی</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-500 dark:text-gray-400">تاریخ ایجاد:</span>
                    <span class="text-gray-800 dark:text-gray-300 block">
                        {{ verta($lesson->created_at)->format('Y/m/d H:i') }}
                    </span>
                </div>
                <div>
                    <span class="text-gray-500 dark:text-gray-400">آخرین بروزرسانی:</span>
                    <span class="text-gray-800 dark:text-gray-300 block">
                        {{ verta($lesson->updated_at)->format('Y/m/d H:i') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- دکمه‌ها -->
        <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
            <div class="space-x-3 space-x-reverse">
                <a href="{{ route('admin.lessons.index') }}"
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 dark:border-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                    بازگشت
                </a>
                <button type="button"
                        onclick="if(confirm('آیا از حذف این درس مطمئن هستید؟')) document.getElementById('delete-form').submit();"
                        class="px-4 py-2 border border-red-300 rounded-lg text-red-700 dark:border-red-600 dark:text-red-300 hover:bg-red-50 dark:hover:bg-red-900">
                    حذف درس
                </button>
            </div>

            <div class="space-x-3 space-x-reverse">
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    بروزرسانی درس
                </button>
            </div>
        </div>
    </form>

    <!-- فرم حذف -->
    <form id="delete-form" action="{{ route('admin.lessons.destroy', $lesson->id) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ویرایشگر متن
        $('#content').summernote({
            height: 300,
            lang: 'fa-IR',
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
@endpush
