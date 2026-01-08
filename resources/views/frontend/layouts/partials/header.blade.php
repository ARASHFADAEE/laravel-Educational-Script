        <header class="bg-background/80 backdrop-blur-xl border-b border-border sticky top-0 z-30"
            x-data="{ offcanvasOpen: false, openSearchBox: false }">
            <!-- container -->
            <div class="max-w-7xl relative px-4 mx-auto">
                <div class="flex items-center gap-8 h-20">
                    <div class="flex items-center gap-3">
                        <!-- offcanvas:button -->
                        <button type="button"
                            class="lg:hidden inline-flex items-center justify-center relative w-10 h-10 bg-secondary rounded-full text-foreground"
                            x-on:click="offcanvasOpen = true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                        <!-- end offcanvas:button -->
                        <a href="{{ Route('home') }}" class="inline-flex items-center gap-2 text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-6 h-6">
                                <path
                                    d="M12 .75a8.25 8.25 0 0 0-4.135 15.39c.686.398 1.115 1.008 1.134 1.623a.75.75 0 0 0 .577.706c.352.083.71.148 1.074.195.323.041.6-.218.6-.544v-4.661a6.714 6.714 0 0 1-.937-.171.75.75 0 1 1 .374-1.453 5.261 5.261 0 0 0 2.626 0 .75.75 0 1 1 .374 1.452 6.712 6.712 0 0 1-.937.172v4.66c0 .327.277.586.6.545.364-.047.722-.112 1.074-.195a.75.75 0 0 0 .577-.706c.02-.615.448-1.225 1.134-1.623A8.25 8.25 0 0 0 12 .75Z" />
                                <path fill-rule="evenodd"
                                    d="M9.013 19.9a.75.75 0 0 1 .877-.597 11.319 11.319 0 0 0 4.22 0 .75.75 0 1 1 .28 1.473 12.819 12.819 0 0 1-4.78 0 .75.75 0 0 1-.597-.876ZM9.754 22.344a.75.75 0 0 1 .824-.668 13.682 13.682 0 0 0 2.844 0 .75.75 0 1 1 .156 1.492 15.156 15.156 0 0 1-3.156 0 .75.75 0 0 1-.668-.824Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="flex flex-col items-start">
                                <span class="font-semibold text-sm text-muted">آکــــادمـــی</span>
                                <span class="font-black text-xl">نـــابــــغه</span>
                            </span>
                        </a>
                    </div>
                    <div class="lg:flex hidden items-center gap-5">
                        <!-- categories -->
                        <div class="relative group/categories">
                            <a href="#"
                                class="inline-flex items-center gap-1 text-muted transition-colors hover:text-foreground">
                                <span class="font-semibold text-sm">دسته بندی آمـــوزشها</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </a>
                            <div
                                class="absolute right-0 top-full opacity-0 invisible transition-all group-hover/categories:opacity-100 group-hover/categories:visible pt-5 z-10">
                                <ul
                                    class="flex flex-col relative w-56 min-h-[300px] bg-background border border-border shadow-2xl shadow-black/5">
                                    @foreach ($course_categories as $category )
                                        
                                    <li >
                                        <a href="#"
                                            class="flex items-center relative text-foreground transition-colors hover:text-primary p-3">
                                            <span class="font-semibold text-sm">{{$category->name}}</span>
                                            <span class="absolute left-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15.75 19.5 8.25 12l7.5-7.5" />
                                                </svg>
                                            </span>
                                        </a>

                                    </li>
                                     @endforeach


                                </ul>
                            </div>
                        </div>
                        <!-- end categories -->

                        <!-- menu -->
                        <ul class="flex items-center gap-5">
                            <li>
                                <a href="./blog.html"
                                    class="inline-flex text-muted transition-colors hover:text-foreground">
                                    <span class="font-semibold text-sm">مقالات آموزشی</span>
                                </a>
                            </li>
                            <li class="relative group/submenu">
                                <a href="#"
                                    class="inline-flex items-center gap-1 text-muted transition-colors hover:text-foreground">
                                    <span class="font-semibold text-sm">لینکهای مفید</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="w-5 h-5 transition-transform group-hover/submenu:rotate-180">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </a>
                                <ul
                                    class="absolute top-full right-0 w-56 bg-background border border-border rounded-xl shadow-2xl shadow-black/5 opacity-0 invisible transition-all group-hover/submenu:opacity-100 group-hover/submenu:visible p-3 mt-2">
                                    <li>
                                        <a href="./profile.html"
                                            class="flex items-center gap-2 w-full text-foreground transition-colors hover:text-primary px-3 py-2">
                                            <span class="font-semibold text-xs">مشاهده پروفایل</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('user.courses')}}"
                                            class="flex items-center gap-2 w-full text-foreground transition-colors hover:text-primary px-3 py-2">
                                            <span class="font-semibold text-xs">دوره ها</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('user.payments')}}"
                                            class="flex items-center gap-2 w-full text-foreground transition-colors hover:text-primary px-3 py-2">
                                            <span class="font-semibold text-xs">مالی</span>
                                        </a>
                                    </li>

                                    <li>
                                        <form action="{{ route('auth.logout') }}" method="post">
                                            @csrf
                                            <button type="submit"
                                                class="flex items-center gap-2 w-full text-red-500 transition-colors hover:text-red-700 px-3 py-2">
                                                <span class="font-semibold text-xs">خروج از حساب</span>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <!-- end menu -->
                    </div>

                    <div class="flex items-center md:gap-5 gap-3 mr-auto">
                        <!-- darkMode:button -->
                        <button type="button"
                            class="hidden lg:inline-flex items-center justify-center w-10 h-10 bg-secondary rounded-full text-foreground"
                            id="dark-mode-button">
                            <span class="light-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                                </svg>
                            </span>
                            <span class="dark-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                                </svg>
                            </span>
                        </button>
                        <!-- end darkMode:button -->

                        <!-- openSearchBox:button -->
                        <button type="button"
                            class="hidden lg:inline-flex items-center justify-center w-10 h-10 bg-secondary rounded-full text-foreground"
                            x-on:click="openSearchBox = true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </button>
                        <!-- end openSearchBox:button -->

                        <a href="{{ route('cart.index') }}"
                            class="inline-flex items-center justify-center relative w-10 h-10 bg-secondary rounded-full text-foreground cart-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>
                            <span class="absolute -top-1 left-0 flex h-5 w-5">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                                <span id="cart_count"
                                    class="relative inline-flex items-center justify-center rounded-full h-5 w-5 bg-primary text-primary-foreground font-bold text-xs">{{ $cart_count }}</span>
                            </span>
                        </a>

                        <!-- user:dropdown -->
                        @if (Auth::check())
                            <div class="relative" x-data="{ isOpen: false }">
                                <button class="flex items-center sm:gap-3 gap-1" x-on:click="isOpen = !isOpen">
                                    <span
                                        class="inline-flex items-center justify-center w-9 h-9 bg-secondary rounded-full text-foreground">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                    </span>
                                    <span class="xs:flex flex-col items-start hidden text-xs space-y-1">
                                        <span class="font-semibold text-foreground">{{ Auth()->user()->name }}</span>
                                        <span class="font-semibold text-muted">خوش آمـــدید</span>
                                    </span>
                                    <span class="text-foreground transition-transform"
                                        x-bind:class="isOpen ? 'rotate-180' : ''">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </span>
                                </button>
                                <div class="absolute top-full left-0 pt-3" x-show="isOpen"
                                    x-on:click.outside="isOpen = false">
                                    <div
                                        class="w-56 bg-background border border-border rounded-xl shadow-2xl shadow-black/5 p-3">
                                        <a href="{{route('user.profile')}}"
                                            class="flex items-center gap-2 w-full text-foreground transition-colors hover:text-primary px-3 py-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                                            </svg>
                                            <span class="font-semibold text-xs">مشاهده پروفایل</span>
                                        </a>
                                        <a href="{{route('user.courses')}}"
                                            class="flex items-center gap-2 w-full text-foreground transition-colors hover:text-primary px-3 py-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                                            </svg>
                                            <span class="font-semibold text-xs">دوره ها</span>
                                        </a>
                                        <a href="{{route('user.payments')}}"
                                            class="flex items-center gap-2 w-full text-foreground transition-colors hover:text-primary px-3 py-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                            </svg>
                                            <span class="font-semibold text-xs">مالی</span>
                                        </a>

                                        <form action="{{ route('auth.logout') }}" method="post">
                                            @csrf
                                            <button type="submit"
                                                class="flex items-center gap-2 w-full text-red-500 transition-colors hover:text-red-700 px-3 py-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                                                </svg>
                                                <span class="font-semibold text-xs">خروج از حساب</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- end user:dropdown -->

                            <!-- login-register:button -->
                            <a href="{{ route('auth.show') }}"
                                class="inline-flex items-center justify-center gap-1 h-10 bg-primary rounded-full text-primary-foreground transition-all hover:opacity-80 px-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-6 h-6">
                                    <path fill-rule="evenodd"
                                        d="M7.5 3.75A1.5 1.5 0 0 0 6 5.25v13.5a1.5 1.5 0 0 0 1.5 1.5h6a1.5 1.5 0 0 0 1.5-1.5V15a.75.75 0 0 1 1.5 0v3.75a3 3 0 0 1-3 3h-6a3 3 0 0 1-3-3V5.25a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3V9A.75.75 0 0 1 15 9V5.25a1.5 1.5 0 0 0-1.5-1.5h-6Zm5.03 4.72a.75.75 0 0 1 0 1.06l-1.72 1.72h10.94a.75.75 0 0 1 0 1.5H10.81l1.72 1.72a.75.75 0 1 1-1.06 1.06l-3-3a.75.75 0 0 1 0-1.06l3-3a.75.75 0 0 1 1.06 0Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-semibold text-sm">حساب کاربری</span>
                            </a>
                        @endif
                        <!-- end login-register:button -->

                    </div>
                </div>

                <!-- searchBox -->
                <div class="absolute inset-x-4 hidden lg:flex flex-col h-full bg-background transition-all"
                    x-bind:class="openSearchBox ? 'top-0' : '-top-full'" x-data="searchBox()">
                    <form class="h-full" @submit.prevent="performSearch()">
                        <div class="flex items-center h-full relative">
                            <input id="SearchKey" x-model="query" x-on:keyup.debounce.300ms="performSearch()"
                                x-ref="searchInput" type="text"
                                class="form-input w-full !ring-0 !ring-offset-0 bg-background border-0 focus:border-0 text-foreground"
                                placeholder="نام دوره، مقاله و یا دسته بندی را وارد نمایید.." :disabled="isLoading" />

                            <!-- دکمه بستن -->
                            <button type="button"
                                class="absolute left-0 inline-flex items-center justify-center w-9 h-9 bg-secondary rounded-full text-muted transition-colors hover:text-red-500"
                                x-on:click="openSearchBox = false; clearSearch()">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <!-- نمایش وضعیت لودینگ -->
                            <div x-show="isLoading" class="absolute left-12">
                                <svg class="animate-spin w-5 h-5 text-primary" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </form>

                    <!-- نتایج جستجو -->
                    <div id="search-results"
                        class="bg-[#ebf9fe] p-4 rounded-lg max-h-96 overflow-y-auto absolute w-full "
                        style="margin-top: 5rem" x-show="query.length >= 2 && (results.length > 0 || noResults)"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0">

                        <!-- هنگام لودینگ -->
                        <div x-show="isLoading" class="text-center py-4">
                            <div class="inline-block animate-spin rounded-full h-6 w-6 border-b-2 border-primary">
                            </div>
                            <p class="mt-2 text-sm text-muted-foreground">در حال جستجو...</p>
                        </div>

                        <!-- نتایج -->
                        <template x-if="!isLoading && results.length > 0">
                            <div>
                                <div class="mb-3 text-sm text-muted-foreground">
                                    <span x-text="results.length"></span> نتیجه یافت شد
                                </div>
                                <div class="space-y-2">
                                    <template x-for="item in results" :key="item.id">
                                        <a :href="`/blog/${item.slug}`"
                                            class="block p-3 bg-white rounded-lg border border-border hover:border-primary hover:shadow-sm transition-all group">
                                            <div class="font-medium text-foreground group-hover:text-primary"
                                                x-text="item.title"></div>
                                            <template x-if="item.category">
                                                <div class="mt-1 text-xs text-muted-foreground">
                                                    <span x-text="item.category.name"></span>
                                                </div>
                                            </template>
                                            <template x-if="item.excerpt">
                                                <p class="mt-2 text-sm text-muted-foreground line-clamp-2"
                                                    x-text="item.excerpt"></p>
                                            </template>
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <!-- بدون نتیجه -->
                        <div x-show="!isLoading && noResults && query.length >= 2" class="text-center py-6">
                            <svg class="w-12 h-12 mx-auto text-muted-foreground/50 mb-3" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            <p class="text-muted-foreground">نتیجه‌ای برای "<span x-text="query"
                                    class="font-medium"></span>" یافت نشد</p>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('alpine:init', () => {
                        Alpine.data('searchBox', () => ({
                            query: '',
                            results: [],
                            isLoading: false,
                            noResults: false,
                            minLength: 2,

                            init() {
                                // وقتی سرچ باکس باز می‌شود، فوکوس روی اینپوت
                                this.$watch('openSearchBox', (value) => {
                                    if (value) {
                                        setTimeout(() => {
                                            this.$refs.searchInput.focus();
                                        }, 100);
                                    } else {
                                        this.clearSearch();
                                    }
                                });
                            },

                            async performSearch() {
                                // بررسی حداقل طول
                                if (this.query.length < this.minLength) {
                                    this.results = [];
                                    this.noResults = false;
                                    return;
                                }

                                this.isLoading = true;
                                this.noResults = false;

                                try {
                                    const response = await fetch(`/Search?q=${encodeURIComponent(this.query)}`);

                                    if (!response.ok) {
                                        throw new Error('خطا در ارتباط با سرور');
                                    }

                                    const data = await response.json();
                                    this.results = data;
                                    this.noResults = data.length === 0;

                                } catch (error) {
                                    console.error('Search error:', error);
                                    this.results = [];
                                    this.noResults = true;

                                    // نمایش خطا در نتایج
                                    this.results = [{
                                        id: 'error',
                                        title: 'خطا در جستجو',
                                        excerpt: 'لطفاً دوباره تلاش کنید',
                                        slug: '#'
                                    }];

                                } finally {
                                    this.isLoading = false;
                                }
                            },

                            clearSearch() {
                                this.query = '';
                                this.results = [];
                                this.noResults = false;
                                this.isLoading = false;
                            },

                            selectResult(item) {
                                // هدایت به صفحه نتیجه
                                window.location.href = `/blog/${item.slug}`;
                            }
                        }));
                    });
                </script>
                <!-- end searchBox -->
            </div>
            <!-- end container -->

            <!-- offcanvas -->
            <div x-cloak>
                <!-- offcanvas:box -->
                <div class="fixed inset-y-0 right-0 xs:w-80 w-72 h-screen bg-background rounded-l-2xl overflow-y-auto transition-transform z-50"
                    x-bind:class="offcanvasOpen ? '!translate-x-0' : 'translate-x-full'">
                    <!-- offcanvas:header -->
                    <div class="flex items-center justify-between gap-x-4 sticky top-0 bg-background p-4 z-10">
                        <a href="./home.html" class="inline-flex items-center gap-2 text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-6 h-6">
                                <path
                                    d="M12 .75a8.25 8.25 0 0 0-4.135 15.39c.686.398 1.115 1.008 1.134 1.623a.75.75 0 0 0 .577.706c.352.083.71.148 1.074.195.323.041.6-.218.6-.544v-4.661a6.714 6.714 0 0 1-.937-.171.75.75 0 1 1 .374-1.453 5.261 5.261 0 0 0 2.626 0 .75.75 0 1 1 .374 1.452 6.712 6.712 0 0 1-.937.172v4.66c0 .327.277.586.6.545.364-.047.722-.112 1.074-.195a.75.75 0 0 0 .577-.706c.02-.615.448-1.225 1.134-1.623A8.25 8.25 0 0 0 12 .75Z" />
                                <path fill-rule="evenodd"
                                    d="M9.013 19.9a.75.75 0 0 1 .877-.597 11.319 11.319 0 0 0 4.22 0 .75.75 0 1 1 .28 1.473 12.819 12.819 0 0 1-4.78 0 .75.75 0 0 1-.597-.876ZM9.754 22.344a.75.75 0 0 1 .824-.668 13.682 13.682 0 0 0 2.844 0 .75.75 0 1 1 .156 1.492 15.156 15.156 0 0 1-3.156 0 .75.75 0 0 1-.668-.824Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="flex flex-col items-start">
                                <span class="font-semibold text-sm text-muted">آکــــادمـــی</span>
                                <span class="font-black text-xl">نـــابــــغه</span>
                            </span>
                        </a>

                        <!-- offcanvas:close-button -->
                        <button x-on:click="offcanvasOpen = false"
                            class="text-foreground focus:outline-none hover:text-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button><!-- end offcanvas:close-button -->
                    </div><!-- end offcanvas header -->

                    <!-- offcanvas:content -->
                    <div class="space-y-5 p-4">
                        <form action="#" @submit.prevent x-data="{
                            query: '',
                            results: [],
                            isLoading: false,
                            showResults: false
                        }">
                            <div class="flex items-center relative">
                                <input type="text" id="SearchKeyMobile" x-model="query"
                                    x-on:keyup.debounce.300ms="
                if(query.length < 2) {
                    results = [];
                    showResults = false;
                    return;
                }
                
                isLoading = true;
                showResults = true;
                
                fetch(`/Search?q=${encodeURIComponent(query)}`)
                    .then(r => r.json())
                    .then(data => {
                        results = data;
                    })
                    .catch(err => {
                        console.error(err);
                        results = [];
                    })
                    .finally(() => isLoading = false);
            "
                                    x-on:focus="showResults = query.length >= 2"
                                    x-on:click.outside="showResults = false"
                                    class="form-input w-full h-10 !ring-0 !ring-offset-0 bg-secondary border border-border focus:border-primary rounded-xl text-sm text-foreground pr-10"
                                    placeholder="دنبال چی میگردی؟" />

                                <span class="absolute right-3">
                                    <template x-if="!isLoading">
                                        <span class="text-muted">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="w-5 h-5">
                                                <path fill-rule="evenodd"
                                                    d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </span>
                                    </template>

                                    <template x-if="isLoading">
                                        <span class="text-primary">
                                            <svg class="animate-spin w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                        </span>
                                    </template>
                                </span>
                            </div>

                            <!-- نتایج برای موبایل (پاپ‌آپ) -->
                            <div x-show="showResults && results.length > 0" x-transition
                                class="fixed inset-x-4 top-20 z-50 bg-background border border-border rounded-xl shadow-2xl max-h-80 overflow-y-auto"
                                x-cloak>

                                <div class="p-4 border-b border-border">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-foreground">نتایج جستجو</span>
                                        <button x-on:click="showResults = false; query = ''"
                                            class="text-muted-foreground hover:text-error">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="divide-y divide-border">
                                    <template x-for="item in results" :key="item.id">
                                        <a :href="`/blog/${item.slug}`"
                                            class="block p-4 hover:bg-secondary transition-colors"
                                            x-on:click="showResults = false">
                                            <div class="font-medium text-foreground" x-text="item.title"></div>
                                            <template x-if="item.category">
                                                <div class="mt-1 text-xs text-muted-foreground"
                                                    x-text="item.category.name"></div>
                                            </template>
                                        </a>
                                    </template>
                                </div>
                            </div>

                            <!-- backdrop برای موبایل -->
                            <div x-show="showResults" x-transition.opacity class="fixed inset-0 bg-black/50 z-40"
                                x-cloak x-on:click="showResults = false">
                            </div>
                        </form>
                        <div class="h-px bg-border"></div>
                        <label class="relative w-full flex items-center justify-between cursor-pointer">
                            <span class="font-bold text-sm text-foreground">تم تاریک</span>
                            <input type="checkbox" class="sr-only peer" id="dark-mode-checkbox" />
                            <div
                                class="w-11 h-5 relative bg-background border-2 border-border peer-focus:outline-none rounded-full peer peer-checked:after:left-[26px] peer-checked:after:bg-background after:content-[''] after:absolute after:left-0.5 after:top-0.5 after:bg-border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-primary peer-checked:border-primary">
                            </div>
                        </label>
                        <div class="h-px bg-border"></div>
                        <ul class="flex flex-col space-y-1">
                            <li x-data="{ open: false }">
                                <button type="button"
                                    class="w-full flex items-center gap-x-2 relative transition-all hover:text-foreground py-2"
                                    x-bind:class="open ? 'text-foreground' : 'text-muted'" x-on:click="open = !open">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M3 9a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 9Zm0 6.75a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="font-semibold text-xs">دسته بندی آموزشها</span>
                                    <span class="absolute left-3" x-bind:class="open ? 'rotate-180' : ''">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                                        </svg>
                                    </span>
                                </button>
                                <ul class="flex flex-col relative before:content-[''] before:absolute before:inset-y-3 before:right-3 before:w-px before:bg-zinc-200 dark:before:bg-zinc-900 py-3 pr-5"
                                    x-show="open">
                                    <li x-data="{ openChild: false }">
                                        <button type="button"
                                            class="w-full flex items-center gap-x-2 bg-transparent rounded-xl text-zinc-400 transition-all group/nav-item hover:text-black dark:hover:text-white py-2 px-3"
                                            x-on:click="openChild = !openChild">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-4 h-4" x-bind:class="openChild ? '-rotate-45' : ''">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.75 19.5 8.25 12l7.5-7.5"></path>
                                            </svg>
                                            <span class="font-medium text-xs">برنامه نویسی وب</span>
                                        </button>
                                        <ul class="flex flex-col relative before:content-[''] before:absolute before:inset-y-3 before:right-3 before:w-px before:bg-zinc-200 dark:before:bg-zinc-900 py-3 pr-5"
                                            x-show="openChild">
                                            <li>
                                                <a href="./series.html"
                                                    class="w-full flex items-center gap-x-2 bg-transparent rounded-xl text-zinc-400 transition-all group/nav-item hover:text-black dark:hover:text-white py-2 px-3">
                                                    <span
                                                        class="inline-flex w-2 h-px bg-zinc-200 dark:bg-zinc-800 transition-all group-hover/nav-item:w-4 group-hover/nav-item:bg-black dark:group-hover/nav-item:bg-white"></span>
                                                    <span class="font-medium text-xs">جاوااسکریپت</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="./series.html"
                                                    class="w-full flex items-center gap-x-2 bg-transparent rounded-xl text-zinc-400 transition-all group/nav-item hover:text-black dark:hover:text-white py-2 px-3">
                                                    <span
                                                        class="inline-flex w-2 h-px bg-zinc-200 dark:bg-zinc-800 transition-all group-hover/nav-item:w-4 group-hover/nav-item:bg-black dark:group-hover/nav-item:bg-white"></span>
                                                    <span class="font-medium text-xs">نود جی اس</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="./series.html"
                                                    class="w-full flex items-center gap-x-2 bg-transparent rounded-xl text-zinc-400 transition-all group/nav-item hover:text-black dark:hover:text-white py-2 px-3">
                                                    <span
                                                        class="inline-flex w-2 h-px bg-zinc-200 dark:bg-zinc-800 transition-all group-hover/nav-item:w-4 group-hover/nav-item:bg-black dark:group-hover/nav-item:bg-white"></span>
                                                    <span class="font-medium text-xs">ریکت جی اس</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="./series.html"
                                                    class="w-full flex items-center gap-x-2 bg-transparent rounded-xl text-zinc-400 transition-all group/nav-item hover:text-black dark:hover:text-white py-2 px-3">
                                                    <span
                                                        class="inline-flex w-2 h-px bg-zinc-200 dark:bg-zinc-800 transition-all group-hover/nav-item:w-4 group-hover/nav-item:bg-black dark:group-hover/nav-item:bg-white"></span>
                                                    <span class="font-medium text-xs">...</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="./series.html"
                                            class="w-full flex items-center gap-x-2 bg-transparent rounded-xl text-zinc-400 transition-all group/nav-item hover:text-black dark:hover:text-white py-2 px-3">
                                            <span
                                                class="inline-flex w-2 h-px bg-zinc-200 dark:bg-zinc-800 transition-all group-hover/nav-item:w-4 group-hover/nav-item:bg-black dark:group-hover/nav-item:bg-white"></span>
                                            <span class="font-medium text-xs">دیتا ساینس</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="./series.html"
                                            class="w-full flex items-center gap-x-2 bg-transparent rounded-xl text-zinc-400 transition-all group/nav-item hover:text-black dark:hover:text-white py-2 px-3">
                                            <span
                                                class="inline-flex w-2 h-px bg-zinc-200 dark:bg-zinc-800 transition-all group-hover/nav-item:w-4 group-hover/nav-item:bg-black dark:group-hover/nav-item:bg-white"></span>
                                            <span class="font-medium text-xs">زبانهای برنامه نویسی</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="./series.html"
                                            class="w-full flex items-center gap-x-2 bg-transparent rounded-xl text-zinc-400 transition-all group/nav-item hover:text-black dark:hover:text-white py-2 px-3">
                                            <span
                                                class="inline-flex w-2 h-px bg-zinc-200 dark:bg-zinc-800 transition-all group-hover/nav-item:w-4 group-hover/nav-item:bg-black dark:group-hover/nav-item:bg-white"></span>
                                            <span class="font-medium text-xs">...</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"
                                    class="w-full flex items-center gap-x-2 relative text-muted transition-all hover:text-foreground py-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z">
                                        </path>
                                    </svg>
                                    <span class="font-semibold text-xs">پرسش و پاسخ</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="w-full flex items-center gap-x-2 relative text-muted transition-all hover:text-foreground py-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z">
                                        </path>
                                    </svg>
                                    <span class="font-semibold text-xs">مقالات آموزشی</span>
                                </a>
                            </li>
                        </ul>
                    </div><!-- end offcanvas:content -->
                </div><!-- end offcanvas:box -->

                <!-- offcanvas:overlay -->
                <div class="fixed inset-0 h-screen bg-secondary/80 cursor-pointer transition-all duration-1000 z-40"
                    x-bind:class="offcanvasOpen ? 'opacity-100 visible' : 'opacity-0 invisible'"
                    x-on:click="offcanvasOpen = false">
                </div><!-- end offcanvas:overlay -->
            </div><!-- end offcanvas -->
        </header>
