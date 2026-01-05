@extends('admin.layouts.master')

@section('title', 'ایجاد مقاله جدید')

@section('main')

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 max-w-5xl mx-auto">

        <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">ایجاد مقاله جدید</h2>

        <form action="{{route('admin.post.store')}}" method="POST" class="space-y-6" enctype="multipart/form-data">
            @csrf

            <!-- عنوان مقاله -->
            <div>
                <label class="form-label">عنوان مقاله <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" class="form-input w-full"
                    placeholder="مثال: آموزش کامل Laravel از صفر تا صد" required>
                @error('title')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- اسلاگ -->
            <div>
                <label class="form-label">اسلاگ (Slug)</label>
                <input type="text" name="slug" value="{{ old('slug') }}" class="form-input w-full"
                    placeholder="laravel-tutorial-2026">
                <p class="text-sm text-gray-500 mt-1">اگر خالی بماند، به صورت خودکار از عنوان ساخته می‌شود.</p>
                @error('slug')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- دسته‌بندی -->
            <div>
                <label class="form-label">دسته‌بندی <span class="text-red-500">*</span></label>
                <select name="category_id" class="form-input w-full" required>
                    <option value="">انتخاب دسته‌بندی</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="p-5 bg-red ">
                <label for="thumbnail">تصویر مقاله</label>
                <br>
                <input type="file" name="thumbnail" >
            </div>
            <!-- بدنه مقاله (با Summernote) -->
            <div>
                <label class="form-label">محتوای مقاله <span class="text-red-500">*</span></label>
                <textarea name="body" id="body" rows="10" class="form-input w-full"
                    placeholder="محتوای کامل مقاله را اینجا بنویسید...">{{ old('body') }}</textarea>
                @error('body')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- وضعیت -->
            <div>
                <label class="form-label">وضعیت مقاله</label>
                <select name="status" class="form-input w-full">
                    <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>پیش‌نویس</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>منتشر شده</option>
                </select>
            </div>

            <!-- بخش تنظیمات SEO -->
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-5 border border-gray-200 dark:border-gray-600">
                <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">تنظیمات سئو (SEO)</h3>

                <div class="space-y-4">
                    <!-- Meta Title -->
                    <div>
                        <label class="form-label">عنوان سئو (Meta Title)</label>
                        <input type="text" name="seo[meta_title]" value="{{ old('seo.meta_title') }}"
                            class="form-input w-full" placeholder="عنوان نمایش داده شده در نتایج گوگل">
                        <p class="text-sm text-gray-500 mt-1">توصیه: حداکثر ۶۰ کاراکتر</p>
                    </div>

                    <!-- Meta Description -->
                    <div>
                        <label class="form-label">توضیحات سئو (Meta Description)</label>
                        <textarea name="seo[meta_description]" rows="3" class="form-input w-full"
                            placeholder="توضیح مختصر و جذاب برای نمایش در گوگل...">{{ old('seo.meta_description') }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">توصیه: ۱۵۰-۱۶۰ کاراکتر</p>
                    </div>

                    <!-- Meta Keywords -->
                    <div>
                        <label class="form-label">کلمات کلیدی (Meta Keywords)</label>
                        <input type="text" name="seo[meta_keywords]" value="{{ old('seo.meta_keywords') }}"
                            class="form-input w-full" placeholder="laravel, آموزش لاراول, برنامه نویسی">
                        <p class="text-sm text-gray-500 mt-1">با کاما جدا کنید (اختیاری)</p>
                    </div>
                </div>
            </div>

            <!-- دکمه‌ها -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('admin.posts.index') }}" class="btn-secondary">
                    بازگشت به لیست
                </a>

                <div class="space-x-3 space-x-reverse">
                    <button type="submit" name="action" value="draft" class="btn-secondary">
                        ذخیره به عنوان پیش‌نویس
                    </button>
                    <button type="submit" name="action" value="publish" class="text-white px-6 py-3 rounded"
                        style="background: #2a77ff;">
                        انتشار مقاله
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Summernote JS --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.css" rel="stylesheet">

        <script>
            $(document).ready(function() {
                $('#body').summernote({
                    height: 400,
                    lang: 'fa',
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                });
            });
        </script>
    @endpush

@endsection
