@extends('admin.layouts.master')

@section('title', 'مدیریت دیدگاه‌ها')

@section('main')

    <div class="overflow-x-auto shadow-lg rounded-lg">
        <header>
            <div class="px-6 py-4 border-b flex items-center justify-between bg-gray-900">
                <div>
                    <h2 class="text-lg font-semibold text-gray-100">مدیریت دیدگاه‌ها</h2>
                    <div class="flex gap-4 mt-2 text-sm">
                        <span class="text-yellow-400">
                            منتظر بررسی: <strong>{{ $pendingCount }}</strong>
                        </span>
                        <span class="text-green-400">
                            تایید شده: <strong>{{ $approvedCount }}</strong>
                        </span>
                        <span class="text-red-400">
                            رد شده: <strong>{{ $rejectedCount }}</strong>
                        </span>
                    </div>
                </div>
                <a href="{{ route('admin.comments.approved') }}"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow-sm inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    دیدگاه‌های تایید شده
                </a>
            </div>
        </header>

        @if ($comments->count() > 0)
            <table class="min-w-full table-auto">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-6 py-4 text-right text-sm font-medium">شناسه</th>
                        <th class="px-6 py-4 text-right text-sm font-medium">نویسنده</th>
                        <th class="px-6 py-4 text-right text-sm font-medium">متن دیدگاه</th>
                        <th class="px-6 py-4 text-right text-sm font-medium">مقاله</th>
                        <th class="px-6 py-4 text-right text-sm font-medium">وضعیت</th>
                        <th class="px-6 py-4 text-right text-sm font-medium">تاریخ</th>
                        <th class="px-6 py-4 text-right text-sm font-medium">عملیات</th>
                    </tr>
                </thead>
                <tbody class="text-white divide-y divide-gray-700">
                    @foreach ($comments as $comment)
                        <tr class="hover:bg-gray-800 transition">
                            <td class="px-6 py-4 text-sm">{{ $comment->id }}</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-2">
                                    <div>
                                        <div class="font-medium">{{ $comment->user->name }}</div>
                                        <div class="text-xs text-gray-400">{{ $comment->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm max-w-md">
                                <div class="truncate" title="{{ $comment->body }}">
                                    {{ Str::limit($comment->body, 50) }}
                                </div>
                                @if ($comment->parent_id)
                                    <span class="text-xs text-blue-400 block mt-1">⤷ پاسخ به کامنت</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ route('single.blog.show', $comment->post->slug) }}" 
                                    target="_blank"
                                    class="text-blue-400 hover:text-blue-300">
                                    {{ Str::limit($comment->post->title, 30) }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @switch($comment->status)
                                    @case('pending')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-900 text-yellow-200">
                                            منتظر بررسی
                                        </span>
                                    @break

                                    @case('approved')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-900 text-green-200">
                                            تایید شده
                                        </span>
                                    @break

                                    @case('rejected')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-900 text-red-200">
                                            رد شده
                                        </span>
                                    @break
                                @endswitch
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-400">
                                {{ verta($comment->created_at)->format('Y/m/d H:i') }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium">
                                <div class="flex items-center gap-2 flex-wrap">
                                    @if ($comment->status !== 'approved')
                                        <form action="{{ route('admin.comments.approve', $comment->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <button class="text-green-400 hover:text-green-300 text-xs" title="تایید">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif

                                    @if ($comment->status !== 'rejected')
                                        <form action="{{ route('admin.comments.reject', $comment->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <button class="text-red-400 hover:text-red-300 text-xs" title="رد کردن">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-gray-400 hover:text-gray-300 text-xs" title="حذف">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="px-6 py-4 border-t border-gray-700">
                {{ $comments->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                </svg>
                <p>دیدگاه جدیدی منتظر بررسی نیست</p>
            </div>
        @endif
    </div>

@endsection
