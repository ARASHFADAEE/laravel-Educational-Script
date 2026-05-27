@extends('admin.layouts.master')

@section('title', 'ویرایش درس')

@section('main')
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">ویرایش درس: {{ $lesson->title }}</h2>

        <form action="{{ route('admin.lessons.update', $lesson->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            <!-- عنوان -->
            <div>
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                    عنوان درس <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title', $lesson->title) }}"
                    class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    placeholder="عنوان درس" required>
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- دوره -->
            <div>
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                    دوره <span class="text-red-500">*</span>
                </label>
                <select id="Select_Course" name="course_id"
                    class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    required>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}"
                            {{ old('course_id', $lesson->chapter->course_id) == $course->id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- سرفصل -->
            <div>
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                    سرفصل <span class="text-red-500">*</span>
                </label>
                <select id="Result_chapters" name="chapter_id"
                    class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    required>
                    <option value="">انتخاب فصل</option>
                    @foreach ($chapters as $chapter)
                        <option value="{{ $chapter->id }}"
                            {{ old('chapter_id', $lesson->chapter_id) == $chapter->id ? 'selected' : '' }}>
                            {{ $chapter->title }}
                        </option>
                    @endforeach
                </select>
                @error('chapter_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- اسکریپت AJAX (بدون تغییر محتوایی، فقط مطمئن شوید آدرس صحیح است) -->
            <script>
                $(document).ready(function() {
                    $('#Select_Course').on('change', function(e) {
                        e.preventDefault();
                        let course_id = $(this).val();

                        $.ajax({
                            url: '{{ route('course.ajax.admin') }}',
                            method: 'GET',
                            data: {
                                course_id: course_id
                            },
                            success: function(response) {
                                $('#Result_chapters').html(response);
                            }
                        });
                    });
                });
            </script>
            <!-- اسلاگ -->
            <div>
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                    اسلاگ <span class="text-red-500">*</span>
                    <span class="text-xs text-gray-500">(فقط حروف انگلیسی، اعداد و خط‌تیره)</span>
                </label>
                <input type="text" name="slug" value="{{ old('slug', $lesson->slug) }}"
                    class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    placeholder="example-lesson-slug" pattern="[a-z0-9\-]+" required>
                @error('slug')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- محتوا -->
            <div>
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                    محتوای درس
                </label>
                <textarea name="content" id="content" rows="10"
                    class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    placeholder="محتوای کامل درس...">{{ old('content', $lesson->content) }}</textarea>
                @error('content')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- نوع ویدیو و لینک -->
            <div class="space-y-3">
                @php
                    $selectedVideoType = old('video_type', old('is_hls', $lesson->is_hls) ? 'hls' : 'normal');
                @endphp
                <div class="flex flex-wrap items-center gap-4">
                    <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                        <input type="radio" name="video_type" value="normal" class="video-type h-4 w-4 text-blue-600"
                            {{ $selectedVideoType === 'normal' ? 'checked' : '' }}>
                        ویدیوی عادی
                    </label>
                    <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                        <input type="radio" name="video_type" value="hls" class="video-type h-4 w-4 text-blue-600"
                            {{ $selectedVideoType === 'hls' ? 'checked' : '' }}>
                        ویدیوی HLS
                    </label>
                    <input id="is_hls" name="is_hls" type="hidden" value="{{ $selectedVideoType === 'hls' ? 1 : 0 }}">
                </div>

                <div>
                    <label id="video-label" class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                        لینک ویدیو
                    </label>
                    <textarea name="video_url" id="video_url" rows="3"
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="https://example.com/video.mp4">{{ old('video_url', $lesson->video_url) }}</textarea>
                    <p id="video-help" class="text-xs text-gray-500 mt-1">برای ویدیوی عادی، لینک مستقیم ویدیو را وارد کنید.</p>
                    <p class="text-xs text-gray-500 mt-1">نمونه HLS: &lt;script id=&quot;E3AxilIsQkaSADMQU436mA&quot; src=&quot;https://stream.iranhls.com/Video/Embed/E3AxilIsQkaSADMQU436mA&quot;&gt;&lt;/script&gt;</p>
                    @error('video_url')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- لینک فایل ضمیمه -->
            <div>
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                    لینک فایل ضمیمه
                </label>
                <input type="url" name="file_link" value="{{ old('file_link', $lesson->file_link) }}"
                    class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    placeholder="https://example.com/files/lesson.zip">
                <p class="text-xs text-gray-500 mt-1">لینک سورس، تمرین، PDF یا هر فایل مرتبط با درس.</p>
                @error('file_link')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- موقعیت -->
            <div>
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                    موقعیت نمایش
                </label>
                <input type="number" name="position" value="{{ old('position', $lesson->position) }}" min="0"
                    class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    placeholder="ترتیب نمایش درس">
                <p class="text-xs text-gray-500 mt-1">اعداد کمتر ابتدا نمایش داده می‌شوند</p>
                @error('position')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- وضعیت رایگان/پولی -->
            <div class="flex items-center">
                <input type="checkbox" name="is_free" id="is_free" value="1"
                    {{ old('is_free', $lesson->is_free) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 rounded">
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

            const hlsInput = document.getElementById('is_hls');
            const videoLabel = document.getElementById('video-label');
            const videoHelp = document.getElementById('video-help');
            const videoUrl = document.getElementById('video_url');

            function syncVideoType() {
                const selected = document.querySelector('.video-type:checked')?.value || 'normal';
                const isHls = selected === 'hls';
                hlsInput.value = isHls ? '1' : '0';
                videoLabel.textContent = isHls ? 'اسکریپت embed ویدیوی HLS' : 'لینک ویدیو';
                videoHelp.textContent = isHls
                    ? 'برای HLS، کل تگ script دریافتی از IranHLS را وارد کنید.'
                    : 'برای ویدیوی عادی، لینک مستقیم ویدیو را وارد کنید.';
                videoUrl.placeholder = isHls
                    ? '<script id="..." src="https://stream.iranhls.com/Video/Embed/..."></script>'
                    : 'https://example.com/video.mp4';
            }

            document.querySelectorAll('.video-type').forEach((input) => {
                input.addEventListener('change', syncVideoType);
            });
            syncVideoType();
        });
    </script>
@endpush
