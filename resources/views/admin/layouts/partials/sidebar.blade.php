    <aside id="sidebar" class="fixed right-0 top-0 h-full w-72 bg-white dark:bg-gray-900 shadow-2xl transform transition-transform duration-300 z-50 border-l border-gray-200 dark:border-gray-700 overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">پنل ادمین</h2>
                </div>
                <button id="close-sidebar" class="lg:hidden p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <nav class="space-y-1">
                <!-- Dashboard -->
                <a href="{{route('admin.dashboard')}}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }} transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="font-medium">داشبورد</span>
                </a>

                <!-- Content Management -->
                <div class="pt-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">مدیریت محتوا</p>
                    <div x-data="{ open: {{ request()->routeIs('admin.courses.*') || request()->routeIs('admin.chapters.*') || request()->routeIs('admin.lessons.*') || request()->routeIs('admin.course_categories.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="w-full flex items-center justify-between gap-3 px-4 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all group">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-gray-500 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                <span class="font-medium">دوره‌های آموزشی</span>
                            </div>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-cloak class="mt-1 space-y-1 pr-4">
                            <a href="{{route('admin.courses.index')}}" class="flex items-center gap-3 px-4 py-2 text-sm rounded-lg {{ request()->routeIs('admin.courses.*') ? 'text-indigo-600 bg-indigo-50 dark:bg-indigo-900/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                لیست دوره‌ها
                            </a>
                            <a href="{{route('admin.course_categories.index')}}" class="flex items-center gap-3 px-4 py-2 text-sm rounded-lg {{ request()->routeIs('admin.course_categories.*') ? 'text-indigo-600 bg-indigo-50 dark:bg-indigo-900/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                دسته‌بندی دوره‌ها
                            </a>
                            <a href="{{route('admin.chapters.index')}}" class="flex items-center gap-3 px-4 py-2 text-sm rounded-lg {{ request()->routeIs('admin.chapters.*') ? 'text-indigo-600 bg-indigo-50 dark:bg-indigo-900/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                سرفصل‌ها
                            </a>
                            <a href="{{route('admin.lessons.index')}}" class="flex items-center gap-3 px-4 py-2 text-sm rounded-lg {{ request()->routeIs('admin.lessons.*') ? 'text-indigo-600 bg-indigo-50 dark:bg-indigo-900/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                دروس
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Blog Management -->
                <div class="pt-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">وبلاگ</p>
                    <div x-data="{ open: {{ request()->routeIs('admin.posts.*') || request()->routeIs('admin.post.categories.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="w-full flex items-center justify-between gap-3 px-4 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all group">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-gray-500 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                                <span class="font-medium">مدیریت مقالات</span>
                            </div>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-cloak class="mt-1 space-y-1 pr-4">
                            <a href="{{route('admin.posts.index')}}" class="flex items-center gap-3 px-4 py-2 text-sm rounded-lg {{ request()->routeIs('admin.posts.index') ? 'text-indigo-600 bg-indigo-50 dark:bg-indigo-900/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                لیست مقالات
                            </a>
                            <a href="{{route('admin.post.categories.index')}}" class="flex items-center gap-3 px-4 py-2 text-sm rounded-lg {{ request()->routeIs('admin.post.categories.index') ? 'text-indigo-600 bg-indigo-50 dark:bg-indigo-900/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                دسته‌بندی مقالات
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Users -->
                <div class="pt-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">کاربران</p>
                    <a href="{{route('admin.users.index')}}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.users.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }} transition-all group">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.users.*') ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span class="font-medium">مدیریت کاربران</span>
                    </a>
                </div>

                <!-- Financial -->
                <div class="pt-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">مالی</p>
                    <a href="{{route('admin.payments.index')}}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.payments.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }} transition-all group">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.payments.*') ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        <span class="font-medium">پرداخت‌ها</span>
                    </a>
                </div>

                <!-- Interactions -->
                <div class="pt-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">تعاملات</p>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all group">
                        <svg class="w-5 h-5 text-gray-500 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                        </svg>
                        <span class="font-medium">نظرات</span>
                    </a>
                </div>

                <!-- Settings -->
                <div class="pt-2 pb-8">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">تنظیمات</p>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all group">
                        <svg class="w-5 h-5 text-gray-500 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="font-medium">تنظیمات SEO</span>
                    </a>
                </div>
            </nav>
        </div>
    </aside>

    <style>
        [x-cloak] { display: none !important; }
    </style>
