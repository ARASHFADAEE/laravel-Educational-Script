@extends('admin.layouts.master')




@section('title','لیست دوره ها')

@section('main')

<div class="overflow-x-auto bg-white dark:bg-gray-900 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700">
    <header>
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between bg-gray-50 dark:bg-gray-800/50">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">لیست دوره ها</h2>
            <div class="flex item-center gap-3">
            <a href="{{ route('admin.courses.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow-sm inline-flex items-center">
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                افزودن دوره
            </a>
                        <a href="{{ route('admin.course_categories.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow-sm inline-flex items-center">

                دسته بندی دوره ها
            </a>
            </div>
        </div>

    </header>
        <table class="min-w-full table-auto">
            <thead class="bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                <tr>
                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider">شناسه</th>
                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider">نام دوره</th>
                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider">اسلاگ</th>
                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider">وضعیت</th>
                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider">تاریخ ثبت </th>
                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider">عملیات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">


                @foreach ( $courses as $course )

                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $course->id }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $course->title }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $course->slug }}</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $course->status == 'published' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' }}">
                            {{ $course->status == 'published' ? 'منتشر شده' : 'پیش نویس' }}
                        </span>
                    </td>

                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                        {{ verta($course->created_at) }}
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-center space-x-2 space-x-reverse flex items-center gap-3">
                        <!-- دکمه ویرایش -->
                        <a href="{{ route('admin.courses.edit', $course->id) }}" class="p-2 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-all group" title="ویرایش">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <!-- دکمه حذف -->
                        <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-lg bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/50 transition-all group" title="حذف" onclick="return confirm('آیا از حذف این دوره مطمئن هستید؟')">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach



            </tbody>
        </table>
    </div>


@endsection
