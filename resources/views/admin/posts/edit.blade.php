@extends('admin.layouts.master')

@section('title', 'ویرایش مقاله ')

@section('main')
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 max-w-5xl mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">ایجاد مقاله جدید</h2>

        <form action="{{ route('admin.post.update') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
            @csrf
            @if(isset($post) && $post->id)
                <input type="hidden" name="post_id" value="{{ $post->id }}">
            @endif

            <!-- عنوان مقاله -->
            <div>
                <label class="form-label">عنوان مقاله <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $post->title ?? '') }}" 
                       class="form-input text-black w-full" placeholder="مثال: آموزش کامل Laravel از صفر تا صد" required>
                @error('title')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- اسلاگ -->
            <div>
                <label class="form-label">اسلاگ (Slug)</label>
                <input type="text" name="slug" value="{{ old('slug', $post->slug ?? '') }}" 
                       class="form-input text-black w-full" placeholder="laravel-tutorial-2026">
                <p class="text-sm text-gray-500 mt-1">اگر خالی بماند، به صورت خودکار از عنوان ساخته می‌شود.</p>
                @error('slug')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- دسته‌بندی -->
            <div>
                <label class="form-label">دسته‌بندی <span class="text-red-500">*</span></label>
                <select name="category_id" class="form-input text-black w-full" required>
                    <option value="">انتخاب دسته‌بندی</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" 
                                {{ old('category_id', $post->category_id ?? '') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- تصویر مقاله -->
            <div>
                <label class="form-label mb-3 block">تصویر مقاله</label>
                <div class="file-upload-container">
                    <label class="file-upload-label {{ $post->thumbnail ?? '' ? 'has-file' : '' }}">
                        <div class="file-upload-design">
                            <svg viewBox="0 0 640 512" height="1em">
                                <path d="M144 480C64.5 480 0 415.5 0 336c0-62.8 40.2-116.2 96.2-135.9c-.1-2.7-.2-5.4-.2-8.1c0-88.4 71.6-160 160-160c59.3 0 111 32.2 138.7 80.2C409.9 102 428.3 96 448 96c53 0 96 43 96 96c0 12.2-2.3 23.8-6.4 34.6C596 238.4 640 290.1 640 352c0 70.7-57.3 128-128 128H144zm79-217c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l39-39V392c0 13.3 10.7 24 24 24s24-10.7 24-24V257.9l39 39c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-80-80c-9.4-9.4-24.6-9.4-33.9 0l-80 80z"/>
                            </svg>
                            <p>تصویر شاخص را انتخاب کنید</p>
                            <span>یا فایل را اینجا بکشید</span>
                        </div>
                        <input type="file" name="thumbnail" class="file-upload-input" accept="image/*">
                    </label>
                    
                    <!-- پیش‌نمایش تصویر -->
                    <div class="file-preview {{ $post->thumbnail ?? '' ? 'active' : '' }}" id="preview-container">
                        @if(isset($post) && $post->thumbnail)
                            <div class="preview-content">
                                <img src="{{ asset('storage/' . $post->thumbnail) }}" 
                                     class="preview-image" 
                                     alt="تصویر فعلی مقاله">
                                <div class="preview-info">
                                    <p><strong>تصویر فعلی</strong></p>
                                    <p><small>برای تغییر، تصویر جدید انتخاب کنید</small></p>
                                </div>
                                <button type="button" class="remove-file" onclick="removeFile()">
                                    حذف و انتخاب تصویر جدید
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- محتوای مقاله -->
            <div>
                <label class="form-label">محتوای مقاله <span class="text-red-500">*</span></label>
                <textarea class="form-input text-black w-full" id="myeditor" name="body">{{ old('body', $post->body ?? '') }}</textarea>
                @error('body')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- وضعیت -->
            <div>
                <label class="form-label">وضعیت مقاله</label>
                <select name="status" class="form-input text-black w-full">
                    <option value="draft" {{ old('status', $post->status ?? 'draft') == 'draft' ? 'selected' : '' }}>پیش‌نویس</option>
                    <option value="published" {{ old('status', $post->status ?? '') == 'published' ? 'selected' : '' }}>منتشر شده</option>
                </select>
            </div>

            <!-- بخش تنظیمات SEO -->
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-5 border border-gray-200 dark:border-gray-600">
                <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">تنظیمات سئو (SEO)</h3>
                <div class="space-y-4">
                    <!-- Meta Title -->
                    <div>
                        <label class="form-label">عنوان سئو (Meta Title)</label>
                        <input type="text" name="seo[meta_title]" 
                               value="{{ old('seo.meta_title', $post->seo->meta_title ?? '') }}"
                               class="form-input text-black w-full" 
                               placeholder="عنوان نمایش داده شده در نتایج گوگل">
                        <p class="text-sm text-gray-500 mt-1">توصیه: حداکثر ۶۰ کاراکتر</p>
                    </div>

                    <!-- Meta Description -->
                    <div>
                        <label class="form-label">توضیحات سئو (Meta Description)</label>
                        <textarea name="seo[meta_description]" rows="3" class="form-input text-black w-full"
                                  placeholder="توضیح مختصر و جذاب برای نمایش در گوگل...">{{ old('seo.meta_description', $post->seo->meta_description ?? '') }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">توصیه: ۱۵۰-۱۶۰ کاراکتر</p>
                    </div>

                    <!-- Meta Keywords -->
                    <div>
                        <label class="form-label">کلمات کلیدی (Meta Keywords)</label>
                        <input type="text" name="seo[meta_keywords]" 
                               value="{{ old('seo.meta_keywords', $post->seo->meta_keywords ?? '') }}"
                               class="form-input text-black w-full" 
                               placeholder="laravel, آموزش لاراول, برنامه نویسی">
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
                        {{ isset($post) ? 'بروزرسانی پیش‌نویس' : 'ذخیره به عنوان پیش‌نویس' }}
                    </button>
                    <button type="submit" name="action" value="publish" 
                            class="text-white px-6 py-3 rounded" style="background: #2a77ff;">
                        {{ isset($post) ? 'بروزرسانی مقاله' : 'انتشار مقاله' }}
                    </button>
                </div>
            </div>
        </form>
    </div>

    <style>
        /* استایل‌های قبلی */
        .file-upload-container { margin: 20px 0; }
        .file-upload-label { display: block; cursor: pointer; transition: all 0.3s ease; }
        .file-upload-design {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            gap: 12px; padding: 40px 20px; border: 3px dashed; border-radius: 12px;
            text-align: center; transition: all 0.3s ease;
            border-color: #d1d5db; background-color: #f9fafb; color: #6b7280;
        }
        .file-upload-design svg { width: 48px; height: 48px; fill: #9ca3af; transition: fill 0.3s ease; }
        .file-upload-design p { font-size: 18px; font-weight: 600; margin: 0; }
        .file-upload-design span { font-size: 14px; color: #6b7280; }
        .file-upload-input { display: none; }
        .file-upload-label:hover .file-upload-design {
            border-color: #3b82f6; background-color: #eff6ff; transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.1);
        }
        .file-upload-label:hover .file-upload-design svg { fill: #3b82f6; }
        .file-upload-input:focus + .file-upload-design,
        .file-upload-label.has-file .file-upload-design {
            border-color: #10b981; background-color: #ecfdf5; border-style: solid;
        }
        .file-preview { margin-top: 20px; display: none; }
        .file-preview.active { display: block; }
        .preview-image { max-width: 100%; max-height: 300px; border-radius: 8px; 
                         box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .preview-info {
            margin-top: 10px; padding: 10px; background-color: #f3f4f6;
            border-radius: 6px; font-size: 14px;
        }
        .preview-info p { margin: 5px 0; color: #4b5563; }
        .remove-file {
            margin-top: 10px; padding: 8px 16px; background-color: #ef4444; color: white;
            border: none; border-radius: 6px; cursor: pointer; transition: background-color 0.3s ease;
        }
        .remove-file:hover { background-color: #dc2626; }
        
        /* دارک مود */
        .dark .file-upload-design {
            border-color: #4b5563; background-color: #1f2937; color: #d1d5db;
        }
        .dark .file-upload-design svg { fill: #9ca3af; }
        .dark .file-upload-design span { color: #9ca3af; }
        .dark .file-upload-label:hover .file-upload-design {
            border-color: #60a5fa; background-color: #1e40af;
            box-shadow: 0 10px 25px -5px rgba(96, 165, 250, 0.2);
        }
        .dark .file-upload-label:hover .file-upload-design svg { fill: #60a5fa; }
        .dark .file-upload-input:focus + .file-upload-design,
        .dark .file-upload-label.has-file .file-upload-design {
            border-color: #34d399; background-color: #064e3b;
        }
        .dark .preview-info { background-color: #374151; }
        .dark .preview-info p { color: #d1d5db; }
        
        /* حالت درگ */
        .file-upload-design.dragover { border-color: #8b5cf6; background-color: #f5f3ff; transform: scale(1.02); }
        .dark .file-upload-design.dragover { border-color: #a78bfa; background-color: #4c1d95; }
        
        /* استایل برای حالت ویرایش */
        .current-image-badge {
            position: absolute; top: 10px; right: 10px;
            background: rgba(16, 185, 129, 0.9); color: white;
            padding: 4px 8px; border-radius: 4px; font-size: 12px;
        }
        
        /* ریسپانسیو */
        @media (max-width: 640px) {
            .file-upload-design { padding: 30px 15px; }
            .file-upload-design p { font-size: 16px; }
            .file-upload-design svg { width: 36px; height: 36px; }
        }
    </style>

    <script src="https://cdn.tiny.cloud/1/vfy2oipuptjnbbspfdodnrzexwgkhkgyxde74zknmhwh164b/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#myeditor',
            height: 500,
            menubar: true,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help | image media table code',
            language: 'fa_IR',
            directionality: 'rtl',
            images_upload_handler: function (blobInfo, success, failure) {
                var xhr = new XMLHttpRequest();
                var formData = new FormData();
                
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                formData.append('_token', '{{ csrf_token() }}');
                
                xhr.open('POST', '');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var json = JSON.parse(xhr.responseText);
                        if (json && json.location) {
                            success(json.location);
                        } else {
                            failure('Invalid response');
                        }
                    } else {
                        failure('HTTP Error: ' + xhr.status);
                    }
                };
                xhr.send(formData);
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.querySelector('.file-upload-input');
            const previewContainer = document.getElementById('preview-container');
            const label = document.querySelector('.file-upload-label');
            const dropArea = document.querySelector('.file-upload-design');
            const hasExistingImage = {{ isset($post) && $post->thumbnail ? 'true' : 'false' }};
            
            if (!fileInput) return;
            
            // مقداردهی اولیه برای تصویر موجود
            if (hasExistingImage) {
                label.classList.add('has-file');
            }
            
            // تغییر فایل
            fileInput.addEventListener('change', function(e) {
                handleFiles(this.files);
            });
            
            // Drag & Drop
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });
            
            function highlight() {
                dropArea.classList.add('dragover');
            }
            
            function unhighlight() {
                dropArea.classList.remove('dragover');
            }
            
            dropArea.addEventListener('drop', function(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                fileInput.files = files;
                handleFiles(files);
            });
            
            // نمایش پیش‌نمایش
            function handleFiles(files) {
                if (!files || files.length === 0) return;
                
                const file = files[0];
                
                // بررسی نوع فایل
                if (!file.type.match('image.*')) {
                    alert('لطفاً فقط تصویر انتخاب کنید');
                    fileInput.value = '';
                    return;
                }
                
                // بررسی حجم فایل (حداکثر 5MB)
                const maxSize = 5 * 1024 * 1024; // 5MB
                if (file.size > maxSize) {
                    alert('حجم تصویر نباید بیشتر از 5 مگابایت باشد');
                    fileInput.value = '';
                    return;
                }
                
                // نمایش اطلاعات فایل
                label.classList.add('has-file');
                
                // ایجاد پیش‌نمایش جدید
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewContainer.innerHTML = `
                        <div class="preview-content">
                            <div style="position: relative; display: inline-block;">
                                <img src="${e.target.result}" class="preview-image" alt="پیش‌نمایش تصویر جدید">
                                <div class="current-image-badge">تصویر جدید</div>
                            </div>
                            <div class="preview-info">
                                <p><strong>نام فایل:</strong> ${file.name}</p>
                                <p><strong>حجم:</strong> ${formatBytes(file.size)}</p>
                                <p><strong>نوع:</strong> ${file.type}</p>
                                <p><strong>ابعاد:</strong> در حال بارگذاری...</p>
                            </div>
                            <button type="button" class="remove-file" onclick="removeFile()">
                                حذف تصویر
                            </button>
                        </div>
                    `;
                    previewContainer.classList.add('active');
                    
                    // نمایش ابعاد تصویر
                    const img = new Image();
                    img.onload = function() {
                        const dimensionsElement = previewContainer.querySelector('.preview-info p:nth-child(4)');
                        dimensionsElement.innerHTML = `<strong>ابعاد:</strong> ${this.width} × ${this.height} پیکسل`;
                    };
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
        
        // تابع حذف فایل
        window.removeFile = function() {
            const fileInput = document.querySelector('.file-upload-input');
            const previewContainer = document.getElementById('preview-container');
            const label = document.querySelector('.file-upload-label');
            
            // ریست کردن input file
            fileInput.value = '';
            label.classList.remove('has-file');
            
            // اگر تصویر قبلی وجود داشت، نمایش مجدد
            const hasExistingImage = {{ isset($post) && $post->thumbnail ? 'true' : 'false' }};
            
            if (hasExistingImage) {
                previewContainer.innerHTML = `
                    <div class="preview-content">
                        <img src="{{ asset('storage/' . ($post->thumbnail ?? '')) }}" 
                             class="preview-image" 
                             alt="تصویر فعلی مقاله">
                        <div class="preview-info">
                            <p><strong>تصویر فعلی</strong></p>
                            <p><small>برای تغییر، تصویر جدید انتخاب کنید</small></p>
                        </div>
                        <button type="button" class="remove-file" onclick="removeFile()">
                            حذف و انتخاب تصویر جدید
                        </button>
                    </div>
                `;
                previewContainer.classList.add('active');
                label.classList.add('has-file');
            } else {
                // اگر تصویر قبلی نبود، پیش‌نمایش را مخفی کن
                previewContainer.classList.remove('active');
                previewContainer.innerHTML = '';
            }
        };
        
        // تابع فرمت‌بندی حجم فایل
        function formatBytes(bytes, decimals = 2) {
            if (bytes === 0) return '0 Bytes';
            
            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            
            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }
    </script>
@endsection