<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')-پنل ادمین</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{asset('frontend/css/toastify.css')}}">


</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-gray-100 transition-colors duration-300">

    <!-- Sidebar -->
    @include('admin.layouts.partials.sidebar')


    <!-- Main Content -->
       <main class="lg:mr-64 min-h-screen transition-all duration-300">
        <!-- Top Bar -->
        <header class="bg-white dark:bg-gray-900 shadow-sm border-b border-gray-200 dark:border-gray-700 sticky top-0 z-40">
            <div class="px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button id="menu-toggle" class="lg:hidden p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                </div>
                
                <div class="flex items-center gap-3">
                    <button id="dark-toggle" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                        <svg id="sun-icon" class="w-6 h-6 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <svg id="moon-icon" class="w-6 h-6 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>
                    
                    <button class="relative p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                    
                    <div class="flex items-center gap-3 pr-3 border-r border-gray-200 dark:border-gray-700">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=6366f1&color=fff" class="w-10 h-10 rounded-full ring-2 ring-indigo-500" alt="Avatar">
                        <div class="text-right">
                            <p class="text-sm font-semibold">آرش فدایی</p>
                            <p class="text-xs text-gray-500">مدیر سیستم</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

    @yield('main')

    </main>

        <script src="{{asset('frontend/js/toastify.js')}}"></script>

@if (session('success'))
    <script>
        Toastify({
            text: "{{ session('success') }}",  // یا متن ثابت: "ورود موفقیت آمیز بود"
            duration: 2000,  // اختیاری: زمان نمایش (میلی‌ثانیه)
            gravity: "top",   // اختیاری: top یا bottom
            position: "right", // اختیاری: right, left, center
            className: "info",
            style: {
                background: "green",
            }
        }).showToast();
    </script>
@endif
</body>

      