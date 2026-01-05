@extends('admin.layouts.master')




@section('title','کاربران')

@section('main')

<div class="overflow-x-auto  shadow-lg rounded-lg">
    <header>
        <div class="from-gray-900  px-6 py-4 border-b flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">لیست کاربران</h2>
            <a href="{{ route('admin.users.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow-sm inline-flex items-center">
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                افزودن کاربر
            </a>
        </div>
    </header>
        <table class="min-w-full table-auto">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-6 py-4 text-right text-sm font-medium">شناسه</th>
                    <th class="px-6 py-4 text-right text-sm font-medium">نام</th>
                    <th class="px-6 py-4 text-right text-sm font-medium">ایمیل</th>
                    <th class="px-6 py-4 text-right text-sm font-medium">نقش</th>
                    <th class="px-6 py-4 text-right text-sm font-medium">تاریخ ثبت‌نام</th>
                    <th class="px-6 py-4 text-right text-sm font-medium">عملیات</th>
                </tr>
            </thead>
            <tbody class=" text-white divide-y divide-gray-200">
                @foreach ( $users as $user )
                    
                
                <tr class=" transition">
                    <td class="px-6 py-4 text-sm text-white">{{ $user->id }}</td>
                    <td class="px-6 py-4 text-sm text-white">{{ $user->name }}</td>
                    <td class="px-6 py-4 text-sm text-white">{{ $user->email }}</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-900 text-white">
                            {{ $user->role }}
                        </span>
                    </td>

                    <td class="px-6 py-4 text-sm text-white">{{$user->created_at}}</td>
                    <td class="px-6 py-4 text-sm font-medium text-center space-x-2 space-x-reverse flex items-center gap-3 ">
                        <!-- دکمه ویرایش -->
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="text-indigo-600  items-center">
                            <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <!-- دکمه حذف -->
                        <form action="{{route('admin.users.destroy',$user->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                        <button  class="text-red-600 hover:text-red-900 inline-flex items-center">
                            <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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