@extends('admin.layouts.master')

@section('title', 'لیست دروس')

@section('main')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg">
    <header class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">لیست دروس</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    مدیریت تمام دروس سایت
                </p>
            </div>
            <a href="{{ route('admin.lessons.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg shadow-sm inline-flex items-center transition-colors">
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                افزودن درس جدید
            </a>
        </div>
    </header>

    @if(session('success'))
        <div class="mx-6 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-4 text-right text-sm font-medium text-gray-700 dark:text-gray-300">شناسه</th>
                    <th class="px-6 py-4 text-right text-sm font-medium text-gray-700 dark:text-gray-300">عنوان درس</th>
                    <th class="px-6 py-4 text-right text-sm font-medium text-gray-700 dark:text-gray-300">نام سرفصل</th>
                    <th class="px-6 py-4 text-right text-sm font-medium text-gray-700 dark:text-gray-300">اسلاگ</th>
                    <th class="px-6 py-4 text-right text-sm font-medium text-gray-700 dark:text-gray-300">موقعیت</th>
                    <th class="px-6 py-4 text-right text-sm font-medium text-gray-700 dark:text-gray-300">وضعیت</th>
                    <th class="px-6 py-4 text-right text-sm font-medium text-gray-700 dark:text-gray-300">تاریخ ایجاد</th>
                    <th class="px-6 py-4 text-right text-sm font-medium text-gray-700 dark:text-gray-300">عملیات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($lessons as $lesson)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-300">
                        {{ $lesson->id }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-300">
                        <div class="font-medium">{{ $lesson->title }}</div>
                        @if($lesson->content)
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                {{ Str::limit(strip_tags($lesson->content), 50) }}
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-300">

                            {{ $lesson->chapter->title ?? 'بدون دوره' }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-300">
                        <code class="text-xs bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
                            {{ $lesson->slug }}
                        </code>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-300">
                        <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded">
                            {{ $lesson->position ?? 0 }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        @if($lesson->is_free)
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                رایگان
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                پولی
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-300">
                        {{ verta($lesson->created_at)->format('Y/m/d') }}
                    </td>
                    <td class="px-6 py-4 text-sm font-medium">
                        <div class="flex items-center space-x-3 space-x-reverse">
                            @if($lesson->video_url)
                                <a href="{{ $lesson->video_url }}" target="_blank"
                                   class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300"
                                   title="مشاهده ویدیو">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </a>
                            @endif
                            <a href=""
                               class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
                               title="مشاهده">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <a href="{{ route('admin.lessons.edit', $lesson->id) }}"
                               class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300"
                               title="ویرایش">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('admin.lessons.destroy', $lesson->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        onclick="if(confirm('آیا از حذف این درس مطمئن هستید؟')) this.form.submit();"
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                        title="حذف">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($lessons->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700 dark:text-gray-400">
                نمایش {{ $lessons->firstItem() }} تا {{ $lessons->lastItem() }} از {{ $lessons->total() }} درس
            </div>
            <div class="flex space-x-2 space-x-reverse">
                @if($lessons->onFirstPage())
                    <span class="px-3 py-1 text-gray-400 dark:text-gray-600 bg-gray-100 dark:bg-gray-800 rounded-lg">قبلی</span>
                @else
                    <a href="{{ $lessons->previousPageUrl() }}" class="px-3 py-1 text-blue-600 dark:text-blue-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">قبلی</a>
                @endif

                @foreach($lessons->getUrlRange(1, $lessons->lastPage()) as $page => $url)
                    @if($page == $lessons->currentPage())
                        <span class="px-3 py-1 bg-blue-600 text-white rounded-lg">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1 text-blue-600 dark:text-blue-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">{{ $page }}</a>
                    @endif
                @endforeach

                @if($lessons->hasMorePages())
                    <a href="{{ $lessons->nextPageUrl() }}" class="px-3 py-1 text-blue-600 dark:text-blue-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">بعدی</a>
                @else
                    <span class="px-3 py-1 text-gray-400 dark:text-gray-600 bg-gray-100 dark:bg-gray-800 rounded-lg">بعدی</span>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>

<!-- فیلتر جستجو -->
<div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow p-4">
    <form action="{{ route('admin.lessons.index') }}" method="GET" class="flex flex-wrap gap-4 items-center">
        <div class="flex-1 min-w-[200px]">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="جستجو بر اساس عنوان یا محتوا..."
                   class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>
        <div>
            <select name="course_id" class="px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="">همه دوره‌ها</option>
                @foreach($courses ?? [] as $course)
                    <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                        {{ $course->title }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <select name="is_free" class="px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="">همه وضعیت‌ها</option>
                <option value="1" {{ request('is_free') == '1' ? 'selected' : '' }}>رایگان</option>
                <option value="0" {{ request('is_free') == '0' ? 'selected' : '' }}>پولی</option>
            </select>
        </div>
        <div class="flex space-x-2 space-x-reverse">
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                جستجو
            </button>
            <a href="{{ route('admin.lessons.index') }}"
               class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 dark:border-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                پاک کردن فیلتر
            </a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // نمایش تعداد کاراکترهای محتوا در hover
    document.addEventListener('DOMContentLoaded', function() {
        const contentCells = document.querySelectorAll('td:nth-child(2)');
        contentCells.forEach(cell => {
            const content = cell.querySelector('.text-xs');
            if (content) {
                cell.title = content.textContent;
            }
        });
    });
</script>
@endpush
