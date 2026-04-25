@extends('frontend.layouts.master')


@section('title', 'صفحه پیدا نشد')

@section('content')
    {{-- Background Decorations (Glow Effects) --}}
    <div class="absolute top-1/4 right-1/4 w-64 h-64 bg-accent/10 dark:bg-accent/20 rounded-full blur-3xl animate-pulse">
    </div>
    <div class="absolute bottom-1/4 left-1/4 w-80 h-80 bg-secondary/10 dark:bg-secondary/20 rounded-full blur-3xl animate-pulse"
        style="animation-delay: 1s;"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <div class="max-w-2xl mx-auto p-6">


            {{-- Content --}}
            <div class="space-y-4">
                <h2 class="text-2xl sm:text-3xl font-bold text-primary dark:text-primary-dark">
                    اوه! به نظر می‌رسد گم شده‌اید
                </h2>
                <p class="text-muted dark:text-muted-dark text-base sm:text-lg max-w-md mx-auto leading-relaxed pt-5">
                    متأسفانه صفحه‌ای که به دنبال آن هستید وجود ندارد یا جابه‌جا شده است. نگران نباشید، می‌توانید به صفحه
                    اصلی بازگردید.
                </p>
            </div>

            {{-- Actions --}}
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a class="inline-flex items-center justify-center gap-1 h-10 bg-primary rounded-full text-primary-foreground transition-all hover:opacity-80 px-4"
                    href="{{ url('/') }}"
                    class="group flex items-center gap-2 px-8 py-3.5 rounded-full bg-accent text-white dark:bg-accent-dark dark:text-primary-dark font-bold text-base shadow-lg shadow-accent/30 hover:shadow-accent/50 hover:-translate-y-1 transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                        class="w-5 h-5 rtl:rotate-180">
                        <path fill-rule="evenodd"
                            d="M9.293 2.293a1 1 0 0 1 1.414 0l7 7A1 1 0 0 1 17 11h-2v7a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1v-4H5a1 1 0 0 1-1-1V8a1 1 0 0 1 .293-.707l7-7Z"
                            clip-rule="evenodd" />
                    </svg>
                    بازگشت به خانه
                </a>

                <a href=""
                    class="flex items-center gap-2 px-8 py-3.5 rounded-full bg-secondary/10 dark:bg-secondary/20 text-primary dark:text-primary-dark font-semibold text-base hover:bg-secondary/20 dark:hover:bg-secondary/30 transition-colors duration-300">
                    تماس با پشتیبانی
                </a>
            </div>

            {{-- Fun Easter Egg / Status --}}
            <div
                class="mt-12 inline-flex items-center gap-2 px-4 py-2 rounded-full bg-secondary/5 dark:bg-secondary/10 border border-secondary/10 dark:border-secondary/20">
                <span class="relative flex h-2 w-2">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                </span>
                <span class="text-xs text-muted dark:text-muted-dark font-medium">سیستم در حال خدمت‌رسانی است</span>
            </div>
        </div>
    </div>

    {{-- Custom Animation Style --}}
    <style>
        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }

            100% {
                transform: translateY(0px);
            }
        }
    </style>

@endsection
