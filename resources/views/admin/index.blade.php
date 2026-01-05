@extends('admin.layouts.master')   
   
@section('title','داشبورد')

@section('main')
   
   


        <div class="p-6">
            <!-- Page Title -->
            <div class="mb-8 animate-fade-in">
                <h1 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-2">داشبورد</h1>
                <p class="text-gray-600 dark:text-gray-400">خوش آمدید! نمای کلی سیستم را مشاهده کنید</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl p-6 text-white shadow-lg card-hover animate-fade-in">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium bg-white/20 px-3 py-1 rounded-full">+12%</span>
                    </div>
                    <h3 class="text-sm font-medium mb-1 opacity-90">تعداد کاربران</h3>
                    <p class="text-3xl font-bold">{{$user_count}}</p>
                </div>

                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg card-hover animate-fade-in" style="animation-delay: 0.1s">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium bg-white/20 px-3 py-1 rounded-full">+8%</span>
                    </div>
                    <h3 class="text-sm font-medium mb-1 opacity-90">دوره‌ها</h3>
                    <p class="text-3xl font-bold">{{$course_count}}</p>
                </div>

                <div class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl p-6 text-white shadow-lg card-hover animate-fade-in" style="animation-delay: 0.2s">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium bg-white/20 px-3 py-1 rounded-full">+24%</span>
                    </div>
                    <h3 class="text-sm font-medium mb-1 opacity-90">پرداخت‌های موفق</h3>
                    <p class="text-3xl font-bold">{{$payment_count}}</p>
                </div>

                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white shadow-lg card-hover animate-fade-in" style="animation-delay: 0.3s">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium bg-white/20 px-3 py-1 rounded-full">+18%</span>
                    </div>
                    <h3 class="text-sm font-medium mb-1 opacity-90">درآمد کل</h3>
                    <p class="text-3xl font-bold">{{$payment_sum}} تومان</p>
                </div>
            </div>


                <!-- Users Table -->
                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-6 card-hover">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">کاربران اخیر</h2>
                        <button class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">مشاهده همه</button>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach ($users_lastest as $user)
                            
                        <div class="flex items-center justify-between p-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name=Arash&background=6366f1&color=fff" class="w-12 h-12 rounded-full" alt="">
                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-gray-100">{{$user->name}}</p>
                                    <p class="text-sm text-gray-500">{{$user->email}}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300 rounded-full text-xs font-medium">{{$user->role}}</span>
                        </div>

                         @endforeach

                    </div>
                </div>


        </div>








    @endsection