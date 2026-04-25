@extends('frontend.layouts.master')

@section('title', optional($course->seo)->meta_title ?? $course->title)
@section('description', optional($course->seo)->meta_description ?? \Illuminate\Support\Str::limit(strip_tags($course->description), 160))
@section('canonical', url()->current())

@section('type', 'product')
@section('og-title', optional($course->seo)->og_title ?? $course->title)
@section('og-description', optional($course->seo)->og_description ?? optional($course->seo)->meta_description ?? \Illuminate\Support\Str::limit(strip_tags($course->description), 160))
@section('og-img', (optional($course->seo)->og_image) ? asset('storage/' . $course->seo->og_image) : asset('storage/' . $course->thumbnail))

@section('twitter-title', optional($course->seo)->twitter_title ?? $course->title)
@section('twitter-description', optional($course->seo)->twitter_description ?? optional($course->seo)->meta_description ?? \Illuminate\Support\Str::limit(strip_tags($course->description), 160))
@section('twitter-img', (optional($course->seo)->twitter_image) ? asset('storage/' . $course->seo->twitter_image) : asset('storage/' . $course->thumbnail))

@section('article:published_time', $course->created_at->toIso8601String())
@section('article:modified_time', $course->updated_at->toIso8601String())
@section('article:author', $course->user->name ?? 'admin')

@section('twitter:label1', 'مدرس دوره')
@section('twitter:data1', $course->user->name ?? 'نامشخص')
@section('twitter:label2', 'مدت زمان')
@section('twitter:data2', $course->time_course ?? 'نامشخص')


@section('content')

    <main class="flex-auto py-5">
        @php
            $userNameParts = Auth::check() ? explode(' ', trim(Auth::user()->name), 2) : ['', ''];
            $defaultFirstName = old('first_name', $userNameParts[0] ?? '');
            $defaultLastName = old('last_name', $userNameParts[1] ?? '');
            $defaultPhone = old('phone', Auth::check() ? (Auth::user()->phone ?? '') : '');
        @endphp

        <div class="flex text-gray-500 dark:text-gray-300 text-base font-normal font-iranyekan"
            style="font-variation-settings: &quot;dots&quot; 1;-webkit-font-smoothing: antialiased">

            <div class="container mx-auto flex flex-col lg:flex-row lg:gap-16 xl:gap-28">
<div class="py-3 sm:py-4 p-4 fixed bottom-0 shadow-normal z-50 right-0 left-0 lg:hidden bg-white">
    <div class="container">
        <div class="flex items-center justify-between gap-3">

            <!-- بخش قیمت -->
            <div class="flex items-center gap-3">
                @if($course->sale_price)
                    <span class="text-xs text-gray-400 line-through whitespace-nowrap">
                        {{ number_format($course->regular_price) }}
                    </span>
                    <span class="text-lg sm:text-xl font-bold text-gray-900 whitespace-nowrap">
                        {{ number_format($course->sale_price) }}
                        <span class="text-xs font-normal text-gray-500">تومان</span>
                    </span>
                @else
                    <span class="text-lg sm:text-xl font-bold text-gray-900 whitespace-nowrap">
                        {{ number_format($course->regular_price) }}
                        <span class="text-xs font-normal text-gray-500">تومان</span>
                    </span>
                @endif
            </div>

            <!-- دکمه‌ها -->
            <div class="flex items-center gap-2 sm:gap-3">

                @if($has_access)
                    <a href="{{ $lesson_one ? route('lesson.show', $lesson_one->slug) : '#' }}"
                        class="flex items-center justify-center gap-1.5 px-4 sm:px-5 py-2 sm:py-2.5 text-sm sm:text-base font-medium text-white bg-green-500 rounded-lg hover:bg-green-600 transition-all whitespace-nowrap">
                        <span>مشاهده دوره</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>

                @else
                    <button type="button" onclick="openCheckoutModal()"
                        class="btn-arash flex items-center justify-center gap-1.5 px-4 sm:px-5 py-2 sm:py-2.5 text-sm sm:text-base font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-all whitespace-nowrap">
                        <span>ثبت‌نام سریع</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h10"/>
                        </svg>
                    </button>
                @endif

            </div>

            </div>
        </div>
</div>
                <div
                    class="h-dvh py-6 sticky top-0 lg:basis-4/12 xl:basis-3/12 hidden lg:flex z-20 relative before:absolute before:w-screen before:-z-10 ">
                    <div class="bg-gradient-to-b from-white via-gray-200 to-white h-full w-full">
                        <div class="flex flex-col gap-4 h-full px-5 pb-16 pt-4 relative mx-0.5 ">
                            <div class="flex flex-col gap-1">
                                <a href="{{ route('home') }}" title="بازگشت"
                                    class="flex items-center gap-2 group p-2 -m-2 rounded-lg transition-all hover:bg-gray-50 dark:bg-slate-800 w-fit">
                                    <svg class="size-4 fill-gray-400 transition-all group-hover:fill-white"
                                        viewBox="0 0 448 512">
                                        <path
                                            d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z">
                                        </path>
                                    </svg>
                                </a>
                    <img class="w-full object-cover rounded-2xl" style="margin-top: 20px"
                        src="{{ asset('storage/' . $course->thumbnail) }}" alt="">

                                <div class="flex flex-col gap-1 px-3 pb-2 pt-1 bg-gray-50 dark:bg-slate-800 rounded-lg -mx-1 mt-4">
                                    <span class="text-sm font-medium text-gray-400">مدرس:</span>
                                    <div class="flex items-center gap-2">
                                        <svg class="size-4 fill-gray-500 dark:fill-gray-300" viewBox="0 0 448 512">
                                            <path
                                                d="M96 128a128 128 0 1 0 256 0A128 128 0 1 0 96 128zm94.5 200.2l18.6 31L175.8 483.1l-36-146.9c-2-8.1-9.8-13.4-17.9-11.3C51.9 342.4 0 405.8 0 481.3c0 17 13.8 30.7 30.7 30.7l131.7 0c0 0 0 0 .1 0l5.5 0 112 0 5.5 0c0 0 0 0 .1 0l131.7 0c17 0 30.7-13.8 30.7-30.7c0-75.5-51.9-138.9-121.9-156.4c-8.1-2-15.9 3.3-17.9 11.3l-36 146.9L238.9 359.2l18.6-31c6.4-10.7-1.3-24.2-13.7-24.2L224 304l-19.7 0c-12.4 0-20.1 13.6-13.7 24.2z">
                                            </path>
                                        </svg>
                                        <span class="text-base font-bold">{{ $course->user->name }}</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1 px-3 pb-2 pt-1 bg-gray-50 dark:bg-slate-800 rounded-lg -mx-1">
                                    <span class="text-sm font-medium text-gray-400">تعداد جلسات:</span>
                                    <div class="flex items-center gap-2">
                                        <svg class="size-4 fill-gray-500 dark:fill-gray-300" viewBox="0 0 576 512">
                                            <path
                                                d="M0 128C0 92.7 28.7 64 64 64l256 0c35.3 0 64 28.7 64 64l0 256c0 35.3-28.7 64-64 64L64 448c-35.3 0-64-28.7-64-64L0 128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2l0 256c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1l0-17.1 0-128 0-17.1 14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z">
                                            </path>
                                        </svg>
                                        <span class="text-base font-bold">{{ $lessons_count }} جلسه</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1 px-3 pb-2 pt-1 bg-gray-50 dark:bg-slate-800 rounded-lg -mx-1">
                                    <span class="text-sm font-medium text-gray-400">طول دوره:</span>
                                    <div class="flex items-center gap-2">
                                        <svg class="size-4 fill-gray-500 dark:fill-gray-300" viewBox="0 0 512 512">
                                            <path
                                                d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm24-392l0 136c0 8-4 15.5-10.7 20l-96 64c-11 7.4-25.9 4.4-33.3-6.7s-4.4-25.9 6.7-33.3L232 243.2 232 120c0-13.3 10.7-24 24-24s24 10.7 24 24z">
                                            </path>
                                        </svg>
                                        <span class="text-base font-bold">{{ $course->time_course }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between gap-4 mt-auto text-black dark:text-white">
                                @if ($course->sale_price)
                                    <span
                                        class="text-base font-bold text-gray-400 relative before:content-[''] before:absolute before:h-0.5 before:-right-1 before:-left-1 before:bg-black before:opacity-15 before:top-1/2">
                                        {{ number_format($course->regular_price) }}
                                    </span>
                                    <span class="text-xl font-extrabold ">{{ number_format($course->sale_price) }}
                                        تومان</span>
                                @else
                                    <span class="text-xl font-extrabold" >{{ number_format($course->regular_price) }}
                                        تومان</span>
                                @endif
                            </div>
                            @if ($has_access)
                                <a href="{{ $lesson_one ? route('lesson.show', $lesson_one->slug) : '#' }}"
                                    class="flex gap-1 justify-center text-base font-medium bg-green-500 text-white px-6 py-2.5 rounded-lg hover:bg-green-600 transition-all -mx-1">
                                    <svg class="size-6 fill-white" viewBox="0 0 640 512" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M579.8 267.7c56.5-56.5 56.5-148 0-204.5c-50-50-127.4-55.5-183.1-16.4l-6.4 4.5C368.6 68 352 92.5 352 119.5L352 144l-144 0 0-24.5c0-27-16.6-51.5-38.3-68.2l-6.4-4.5c-55.7-39-133.1-33.6-183.1 16.4c-56.5 56.5-56.5 148 0 204.5l6.4 4.5C21.4 302 64 302 96.8 271.7l1.7-1.6L128 243.6l0 24.4c0 10.1 5.3 19.4 13.9 24.3l80 46c9.8 5.6 22.4 2.8 28.7-6.2c6.3-9 3.9-21.3-4.5-27.4l-54.1-31.1L192 144l256 0 0 129.6-54.1 31.1c-8.4 6.1-10.8 18.4-4.5 27.4c6.3 9 18.9 11.8 28.7 6.2l80-46c8.6-4.9 13.9-14.2 13.9-24.3l0-24.4 29.5 26.5 1.7 1.6c32.8 30.2 75.4 30.2 110.2 3.6l6.4-4.5zM96 64a32 32 0 1 1 0 64 32 32 0 1 1 0-64zM544 128a32 32 0 1 1 0-64 32 32 0 1 1 0 64zM48 464c0-26.5 21.5-48 48-48l144 0c26.5 0 48 21.5 48 48s-21.5 48-48 48l-144 0c-26.5 0-48-21.5-48-48zm352 0c0-26.5 21.5-48 48-48l144 0c26.5 0 48 21.5 48 48s-21.5 48-48 48l-144 0c-26.5 0-48-21.5-48-48z"/>
                                    </svg>
                                    مشاهده دوره
                                </a>
                            @else
                                <button type="button" onclick="openCheckoutModal()"
                                    class="btn-arash flex gap-1 justify-center text-base font-medium bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 transition-all -mx-1">
                                    ثبت‌نام سریع
                                </button>
                            @endif
                            @if($course->sale_expire_at && $course->sale_expire_at->isFuture())
                            <div class="countdown flex flex-row-reverse items-center justify-center gap-5 ltr mt-8"
                                data-date="{{ $course->sale_expire_at->format('Y-m-d\TH:i:s') }}">
                                <div class="flex flex-col gap-1 items-center text-center">
                                    <span class="day text-2xl font-bold leading-none"></span>
                                    <small class="text-xs font-medium leading-none text-gray-400">روز</small>
                                </div>
                                <div class="flex flex-col gap-1 items-center text-center">
                                    <span class="hour text-2xl font-bold leading-none"></span>
                                    <small class="text-xs font-medium leading-none text-gray-400">ساعت</small>
                                </div>
                                <div class="flex flex-col gap-1 items-center text-center">
                                    <span class="minute text-2xl font-bold leading-none"></span>
                                    <small class="text-xs font-medium leading-none text-gray-400">دقیقه</small>
                                </div>
                                <div class="flex flex-col gap-1 items-center text-center">
                                    <span class="second text-2xl font-bold leading-none"></span>
                                    <small class="text-xs font-medium leading-none text-gray-400">ثانیه</small>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-4 py-4 lg:hidden">
                    <a href="{{ route('home') }}" title="بازگشت به صفحه اصلی"
                        class="flex items-center gap-2 group transition-all hover:text-gray-500 dark:text-gray-300 w-fit">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="size-4 sm:size-5 fill-gray-400 transition-all group-hover:fill-blue-600"
                            viewBox="0 0 448 512"><!--! Font Awesome Pro 6.7.2 by @fontawesome  - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2024 Fonticons, Inc. -->
                            <path
                                d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z">
                            </path>
                        </svg>
                        <span class="text-lg sm:text-xl font-extrabold">بازگشت به صفحه اصلی</span>
                    </a>
                    @if($has_access)
                    <a href="{{ $lesson_one ? route('lesson.show', $lesson_one->slug) : '#' }}"
                        class="flex gap-1 justify-center text-sm sm:text-base font-medium bg-green-500 text-white px-5 sm:px-6 py-2 sm:py-2.5 rounded-lg hover:bg-green-600 transition-all mr-auto">
                        مشاهده دوره
                    </a>
                    @else
                    <button type="button" onclick="openCheckoutModal()"
                        class="flex gap-1 justify-center text-sm sm:text-base font-medium bg-blue-600 text-white px-5 sm:px-6 py-2 sm:py-2.5 rounded-lg hover:bg-blue-700 transition-all mr-auto">
                        ثبت&zwnj;نام سریع
                    </button>
                    @endif
                </div>
                <div class="lg:basis-8/12 xl:basis-9/12 pt-4 md:pt-8 lg:pt-16 pb-96 lg:px-2 flex flex-col gap-20">

                                <div
                                    class="w-full video-with-overlay relative rounded-lg overflow-hidden sidebar transition-all duration-300 mt-4">
                                    <!-- Video -->
                                    <video  class="w-full js-player">
                                        <source src="{{ ($lesson_one && $lesson_one->video_url) ?  $lesson_one->video_url : ($course->video_preview ? asset('storage/' . $course->video_preview) : '#') }}" type="video/mp4">
                                        مرورگر شما از ویدیو پشتیبانی نمی&zwnj;کند.
                                    </video>
                                    <!-- Overlay -->
                                    <div style="background-image: url({{ asset('storage/' . $course->thumbnail ) }});background-size: cover; background-position: center;"
                                        class="w-full overlay absolute inset-0 flex flex-col items-center justify-center text-white cursor-pointer transition-all group">
                                        <div
                                            class="relative size-12 flex items-center justify-center rounded-full transition-all group-hover:scale-110 shadow-[0_0_40px_rgba(255,255,255,0.5)]">
                                            <svg class="size-12 rounded-full" viewBox="0 0 512 512" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_413_3210)">
                                                    <rect x="129" y="122" width="254" height="268" fill="white">
                                                    </rect>
                                                    <path
                                                        d="M0 256C0 188.105 26.9714 122.99 74.9807 74.9807C122.99 26.9714 188.105 0 256 0C323.895 0 389.01 26.9714 437.019 74.9807C485.029 122.99 512 188.105 512 256C512 323.895 485.029 389.01 437.019 437.019C389.01 485.029 323.895 512 256 512C188.105 512 122.99 485.029 74.9807 437.019C26.9714 389.01 0 323.895 0 256ZM188.3 147.1C180.7 151.3 176 159.4 176 168V344C176 352.7 180.7 360.7 188.3 364.9C195.9 369.1 205.1 369 212.6 364.4L356.6 276.4C363.7 272 368.1 264.3 368.1 255.9C368.1 247.5 363.7 239.8 356.6 235.4L212.6 147.4C205.2 142.9 195.9 142.7 188.3 146.9V147.1Z"
                                                        class="fill-gray-500 dark:fill-gray-300"></path>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_413_3210">
                                                        <rect width="512" height="512" fill="white"></rect>
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                            <div
                                                class="rounded-full absolute inset-0  animate-ping duration-1000 transition-all ease-in-out">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                    <div class="flex flex-wrap sm:flex-nowrap gap-2 sm:gap-4 lg:hidden -mt-16">
                        <div class="grow sm:grow-none sm:flex-1 flex flex-col gap-1 px-3 pb-2 pt-1 bg-gray-50 dark:bg-slate-800 rounded-lg">
                            <span class="text-sm font-medium text-gray-400">مدرس:</span>
                            <div class="flex items-center gap-2">
                                <svg class="size-4 fill-gray-500 dark:fill-gray-300" viewBox="0 0 448 512">
                                    <path
                                        d="M96 128a128 128 0 1 0 256 0A128 128 0 1 0 96 128zm94.5 200.2l18.6 31L175.8 483.1l-36-146.9c-2-8.1-9.8-13.4-17.9-11.3C51.9 342.4 0 405.8 0 481.3c0 17 13.8 30.7 30.7 30.7l131.7 0c0 0 0 0 .1 0l5.5 0 112 0 5.5 0c0 0 0 0 .1 0l131.7 0c17 0 30.7-13.8 30.7-30.7c0-75.5-51.9-138.9-121.9-156.4c-8.1-2-15.9 3.3-17.9 11.3l-36 146.9L238.9 359.2l18.6-31c6.4-10.7-1.3-24.2-13.7-24.2L224 304l-19.7 0c-12.4 0-20.1 13.6-13.7 24.2z">
                                    </path>
                                </svg>
                                <span class="text-base font-bold">{{ $course->user->name }}</span>
                            </div>
                        </div>
                        <div class="grow sm:grow-none sm:flex-1 flex flex-col gap-1 px-3 pb-2 pt-1 bg-gray-50 dark:bg-slate-800 rounded-lg">
                            <span class="text-sm font-medium text-gray-400">طول دوره:</span>
                            <div class="flex items-center gap-2">
                                <svg class="size-4 fill-gray-500 dark:fill-gray-300" viewBox="0 0 512 512">
                                    <path
                                        d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm24-392l0 136c0 8-4 15.5-10.7 20l-96 64c-11 7.4-25.9 4.4-33.3-6.7s-4.4-25.9 6.7-33.3L232 243.2 232 120c0-13.3 10.7-24 24-24s24 10.7 24 24z">
                                    </path>
                                </svg>
                                <span class="text-base font-bold">{{ $course->time_course }}</span>
                            </div>
                        </div>
                        <div class="grow sm:grow-none sm:flex-1 flex flex-col gap-1 px-3 pb-2 pt-1 bg-gray-50 dark:bg-slate-800 rounded-lg">
                            <span class="text-sm font-medium text-gray-400">تعداد جلسات:</span>
                            <div class="flex items-center gap-2">
                                <svg class="size-4 fill-gray-500 dark:fill-gray-300" viewBox="0 0 576 512">
                                    <path
                                        d="M0 128C0 92.7 28.7 64 64 64l256 0c35.3 0 64 28.7 64 64l0 256c0 35.3-28.7 64-64 64L64 448c-35.3 0-64-28.7-64-64L0 128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2l0 256c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1l0-17.1 0-128 0-17.1 14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z">
                                    </path>
                                </svg>
                                <span class="text-base font-bold">{{ $lessons_count }} جلسه</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-4 md:gap-6 -mt-12 sm:-mt-8 text-black dark:text-white">
                        <span
                            class="text-2xl md:text-3xl lg:text-4xl font-extrabold leading-normal sm:leading-loose">{{ $course->title }}</span>
                        <div class="truncate-js flex flex-col relative">
                            <div class="truncate-text text-base sm:text-lg sm:font-medium line-clamp-6">
                                {!! $course->description !!}</div>
                            <div class="truncate-toggle">
                                <button
                                    class="flex items-center gap-2 w-fit text-sm font-medium border-2 border-gray-500 px-4 py-1.5 rounded-lg hover:bg-gray-50 dark:bg-slate-800 hover:text-white transition-all relative z-1 group">نمایش
                                    بیشتر
                                    <svg class="size-4 fill-gray-500 dark:fill-gray-300 group-hover:fill-white transition-all"
                                        viewBox="0 0 256 256">
                                        <path
                                            d="M216.49,104.49l-80,80a12,12,0,0,1-17,0l-80-80a12,12,0,0,1,17-17L128,159l71.51-71.52a12,12,0,0,1,17,17Z">
                                        </path>
                                    </svg>
                                </button>
                                <span
                                    class="absolute content-[''] -right-1 -left-1 h-40 bottom-0 bg-gradient-to-t from-white via-white/70 to-transparent"></span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-10">
                        <div class="flex flex-col gap-10">
                            <div
                                class="flex flex-col sm:flex-row items-center gap-4 bg-gray-50 dark:bg-slate-800 sm:bg-transparent p-4 pt-6 sm:p-0 rounded-xl sm:rounded-none">
                                <img src="{{ asset('storage/' . $course->user->avatar) }}"
                                    alt="" class="rounded-full size-14 md:size-16">
                                <div
                                    class="flex flex-col gap-1 md:gap-2 text-center sm:text-right items-center sm:items-start">
                                    <small class="text-sm font-medium text-gray-400">مدرس دوره</small>
                                    <span class="text-lg md:text-xl font-bold md:font-extrabold">{{ $course->user->name }}
                                    </span>
                                </div>
                                <div
                                    class="flex sm:flex-col justify-center items-center text-center gap-2 sm:mr-auto border-2 border-black sm:border-none p-3 mt-4 sm:p-0 sm:m-0  sm:w-fit rounded-lg sm:rounded-none">
                                    <span class="text-xl font-black leading-none">{{ $lessons_count }}</span>
                                    <small class="text-sm font-medium text-gray-400 leading-none">جلسه</small>
                                </div>
                            </div>
                        </div>
                        <div class="accordions flex flex-col gap-1.5 text-black dark:text-white" x-data="{ activeAccordion: null }">
                            @foreach($chapters as $chapter)
                            <div class="accordion group border border-gray-200 dark:border-slate-700 rounded-lg sm:rounded-xl hover:border-gray-500 transition-all"
                                :class="{ 'border-gray-500': activeAccordion === {{ $loop->iteration }} }">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-1.5 sm:gap-3 md:gap-4 px-4 py-3 sm:py-5 relative header cursor-pointer text-base sm:text-lg font-semibold sm:font-bold leading-loose transition-all"
                                    @click="activeAccordion = (activeAccordion === {{ $loop->iteration }} ? null : {{ $loop->iteration }})">
                                    <span class="shrink-0 rounded-full text-sm sm:text-lg px-2.5 py-0.5 bg-blue-600 text-white sm:min-w-28 text-center transition-all">
                                        فصل {{ $loop->iteration }}
                                    </span> {{ $chapter->title }}
                                    <svg class="size-4 sm:size-6 absolute sm:relative left-4 sm:left-0 mr-auto transition-all shrink-0 mt-2 sm:mt-1"
                                        :class="{ 'rotate-180': activeAccordion === {{ $loop->iteration }} }"
                                        fill="#000000" viewBox="0 0 256 256">
                                        <path
                                            d="M216.49,104.49l-80,80a12,12,0,0,1-17,0l-80-80a12,12,0,0,1,17-17L128,159l71.51-71.52a12,12,0,0,1,17,17Z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="content transition-all text-base leading-9 text-gray-500 dark:text-gray-300 mx-4 flex flex-col items-stretch overflow-hidden"
                                    x-show="activeAccordion === {{ $loop->iteration }}">
                                    <ul class="flex flex-col gap-1 pt-1 md:pt-5 mb-4 border-t border-t-gray-100">
                                        @foreach($chapter->lessons as $lesson)
                                        <li class="block sm:flex items-center gap-3 md:gap-6 relative rounded-lg px-2.5 sm:px-4 py-1.5 sm:py-3 text-base md:text-lg font-semibold cursor-pointer transition-all hover:bg-primary-50">
                                            <span class="sm:ml-2 sm:min-w-20 text-xs sm:text-sm md:text-lg font-medium sm:font-bold text-blue-600">
                                                جلسه {{ $loop->iteration }}
                                            </span>
                                            <div class="text-black dark:text-white">{{ $lesson->title }}</div>
                                            @if($lesson->duration)
                                            <small class="mr-auto text-xs sm:text-sm font-light md:font-medium text-gray-400 hidden sm:block">{{ $lesson->duration }} دقیقه</small>
                                            @endif
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex flex-col gap-8 text-black dark:text-white">
                        <span class="text-4xl font-extrabold leading-normal">ضمانت کیفیت دوره</span>
                        <div class="grid xl:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-2 py-4 px-5 border-2 border-black dark:border-slate-700 rounded-xl text-black dark:text-white">
                                <span class="text-2xl font-extrabold leading-loose flex items-center gap-3 text-black dark:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-10 fill-black dark:fill-white"
                                        viewBox="0 0 256 256">
                                        <path
                                            d="M232.76,137.88A28.39,28.39,0,0,0,208.13,133L172,141.26c0-.42,0-.84,0-1.26a32,32,0,0,0-32-32H89.94a35.76,35.76,0,0,0-25.45,10.54L43,140H20A20,20,0,0,0,0,160v40a20,20,0,0,0,20,20H120a11.89,11.89,0,0,0,2.91-.36l64-16a11.4,11.4,0,0,0,1.79-.6l38.82-16.54c.23-.09.45-.19.67-.3a28.61,28.61,0,0,0,4.57-48.32ZM36,196H24V164H36Zm181.68-31.39-37.51,16L118.52,196H60V157l21.46-21.46A11.93,11.93,0,0,1,89.94,132H140a8,8,0,0,1,0,16H112a12,12,0,0,0,0,24h32a12.19,12.19,0,0,0,2.69-.3l67-15.41.47-.12a4.61,4.61,0,0,1,5.82,4.44A4.58,4.58,0,0,1,217.68,164.61ZM164,100a40.36,40.36,0,0,0,5.18-.34,40,40,0,1,0,29.67-59.32A40,40,0,1,0,164,100Zm40-36a16,16,0,1,1-16,16A16,16,0,0,1,204,64ZM164,44a16,16,0,0,1,12.94,6.58A39.9,39.9,0,0,0,164.2,76H164a16,16,0,0,1,0-32Z">
                                        </path>
                                    </svg>
                                    گارانتی یک هفته&zwnj;ای</span>
                                <small class="text-base leading-8 text-black dark:text-white">گارانتی بازگشت وجه تا یک هفته،
                                    ثبت&zwnj;نام شما در
                                    دوره&zwnj;های سون&zwnj;لرن بدون ریسک مالی خواهد بود.</small>
                            </div>
                            <div class="flex flex-col gap-2 py-4 px-5 border-2 border-black dark:border-slate-700 rounded-xl text-black dark:text-white">
                                <span class="text-2xl font-extrabold leading-loose flex items-center gap-3 text-black dark:text-white">
                                    <svg viewBox="0 0 24 24" fill="none" class="size-10 stroke-black dark:stroke-white"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="M8.5 12.5L10.0089 14.0089C10.3526 14.3526 10.5245 14.5245 10.7198 14.5822C10.8914 14.6328 11.0749 14.6245 11.2412 14.5585C11.4305 14.4834 11.5861 14.2967 11.8973 13.9232L16 9M16.3287 4.75855C17.0676 4.77963 17.8001 5.07212 18.364 5.636C18.9278 6.19989 19.2203 6.9324 19.2414 7.67121C19.2623 8.40232 19.2727 8.76787 19.2942 8.85296C19.3401 9.0351 19.2867 8.90625 19.383 9.06752C19.428 9.14286 19.6792 9.40876 20.1814 9.94045C20.6889 10.4778 21 11.2026 21 12C21 12.7974 20.6889 13.5222 20.1814 14.0595C19.6792 14.5912 19.428 14.8571 19.383 14.9325C19.2867 15.0937 19.3401 14.9649 19.2942 15.147C19.2727 15.2321 19.2623 15.5977 19.2414 16.3288C19.2203 17.0676 18.9278 17.8001 18.364 18.364C17.8001 18.9279 17.0676 19.2204 16.3287 19.2414C15.5976 19.2623 15.2321 19.2727 15.147 19.2942C14.9649 19.3401 15.0937 19.2868 14.9325 19.3831C14.8571 19.4281 14.5912 19.6792 14.0595 20.1814C13.5222 20.6889 12.7974 21 12 21C11.2026 21 10.4778 20.6889 9.94047 20.1814C9.40874 19.6792 9.14287 19.4281 9.06753 19.3831C8.90626 19.2868 9.0351 19.3401 8.85296 19.2942C8.76788 19.2727 8.40225 19.2623 7.67121 19.2414C6.93238 19.2204 6.19986 18.9279 5.63597 18.364C5.07207 17.8001 4.77959 17.0676 4.75852 16.3287C4.73766 15.5976 4.72724 15.2321 4.70578 15.147C4.65985 14.9649 4.71322 15.0937 4.61691 14.9324C4.57192 14.8571 4.32082 14.5912 3.81862 14.0595C3.31113 13.5222 3 12.7974 3 12C3 11.2026 3.31113 10.4778 3.81862 9.94048C4.32082 9.40876 4.57192 9.14289 4.61691 9.06755C4.71322 8.90628 4.65985 9.03512 4.70578 8.85299C4.72724 8.7679 4.73766 8.40235 4.75852 7.67126C4.77959 6.93243 5.07207 6.1999 5.63597 5.636C6.19986 5.07211 6.93238 4.77963 7.67121 4.75855C8.40232 4.73769 8.76788 4.72727 8.85296 4.70581C9.0351 4.65988 8.90626 4.71325 9.06753 4.61694C9.14287 4.57195 9.40876 4.32082 9.94047 3.81863C10.4778 3.31113 11.2026 3 12 3C12.7974 3 13.5222 3.31114 14.0595 3.81864C14.5913 4.32084 14.8571 4.57194 14.9325 4.61693C15.0937 4.71324 14.9649 4.65988 15.147 4.70581C15.2321 4.72726 15.5976 4.73769 16.3287 4.75855Z"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                        </g>
                                    </svg>
                                    ۱۸ سال تجربه و اعتماد مشتریان</span>
                                <small class="text-base leading-8 text-black dark:text-white">با اعتماد ۵۰ هزار دانشجو در دو دهه
                                    فعالیت، مسیر یادگیری شما را با اطمینان همراهی می&zwnj;کنیم.</small>
                            </div>
                            <div class="flex flex-col gap-2 py-4 px-5 border-2 border-black dark:border-slate-700 rounded-xl">
                                <span class="text-2xl font-extrabold leading-loose flex items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-10 fill-black dark:fill-white"
                                        viewBox="0 0 256 256">
                                        <path
                                            d="M249,96.1l-56-64a12,12,0,0,0-9-4.1H72a12,12,0,0,0-9,4.1L7,96.1a12,12,0,0,0,.26,16.09l112,120a12,12,0,0,0,17.54,0l112-120A12,12,0,0,0,249,96.1ZM213.55,92H182L152,52h26.55ZM71.88,116l21.19,53L43.61,116Zm86.4,0L128,191.69,97.72,116ZM104,92l24-32,24,32Zm80.12,24h28.27l-49.46,53ZM77.45,52H104L74,92H42.45Z">
                                        </path>
                                    </svg>
                                    یادگیری از بهترین&zwnj;&zwnj;ها</span>
                                <small class="text-base leading-8 text-black dark:text-white">از مدرسین متخصص در بهترین شرکت&zwnj;های
                                    ایران مهارت
                                    مورد نیاز بازار کار را یاد می&zwnj;گیرید.</small>
                            </div>
                            <div class="flex flex-col gap-2 py-4 px-5 border-2 border-black dark:border-slate-700 rounded-xl">
                                <span class="text-2xl font-extrabold leading-loose flex items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-10 fill-black dark:fill-white"
                                        viewBox="0 0 256 256">
                                        <path
                                            d="M204.73,51.85A108.07,108.07,0,0,0,20,128v56a28,28,0,0,0,28,28H64a28,28,0,0,0,28-28V144a28,28,0,0,0-28-28H44.84A84.05,84.05,0,0,1,128,44h.64a83.7,83.7,0,0,1,82.52,72H192a28,28,0,0,0-28,28v40a28,28,0,0,0,28,28h19.6A20,20,0,0,1,192,228H136a12,12,0,0,0,0,24h56a44.05,44.05,0,0,0,44-44V128A107.34,107.34,0,0,0,204.73,51.85ZM64,140a4,4,0,0,1,4,4v40a4,4,0,0,1-4,4H48a4,4,0,0,1-4-4V140Zm124,44V144a4,4,0,0,1,4-4h20v48H192A4,4,0,0,1,188,184Z">
                                        </path>
                                    </svg>
                                    مشاوره اختصاصی</span>
                                <small class="text-base leading-8 text-black dark:text-white">برای شروع یادگیری و یافتن بهترین مسیر
                                    شغلی،
                                    مشاوره اختصاصی دریافت خواهید کرد.</small>
                            </div>
                        </div>
                    </div>



                    <div class="flex flex-col gap-4 sm:gap-8" id="pay">
                        <div class="flex justify-between gap-8 flex-col xl:flex-row">
                            <div class="flex flex-col gap-2 md:gap-4">
                                <span
                                    class="text-2xl md:text-3xl lg:text-4xl font-extrabold leading-normal sm:leading-loose text-black dark:text-white">
                                    ثبت نام / پرداخت اینترنتی
                                </span>
                                <small class="text-lg font-medium text-black dark:text-white">جهت شرکت در دوره، لطفا ثبت نام کنید</small>
                            </div>
                            <div
                                class="flex flex-col gap-2 md:gap-4 items-center xl:items-end text-center xl:text-left -mb-5 sm:-mb-8 xl:mb-0 p-6 xl:p-0 bg-gray-50 dark:bg-slate-800 xl:bg-transparent border xl:border-none border-gray-100 dark:border-slate-700 rounded-xl sm:rounded-2xl xl:rounded-none">
                                @if($course->sale_price)
                                <span
                                    class="text-gray-400 text-lg md:text-xl lg:text-2xl font-medium md:font-bold leading-normal sm:leading-loose relative before:content-[''] before:absolute before:h-0.5 before:bg-gray-400/50 before:rotate-[-10deg] before:top-1/2 before:-left-2 before:-right-2 before:transform before:-translate-y-1/2">
                                    {{ number_format($course->regular_price) }} تومان
                                </span>
                                <span class="text-2xl lg:text-3xl font-extrabold leading-normal sm:leading-loose">
                                    {{ number_format($course->sale_price) }} تومان
                                </span>
                                @else
                                <span class="text-2xl lg:text-3xl font-extrabold leading-normal sm:leading-loose">
                                    {{ number_format($course->regular_price) }} تومان
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-col gap-2 mt-3 p-6 sm:p-8 bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-xl sm:rounded-2xl">
                            <h3 class="block text-2xl font-black">
                                <span class="text-blue-600">{{ Auth::check() ? Auth::user()->name : 'کاربر عزیز' }}</span>،
                                سلام
                            </h3>
                            <span class="text-lg font-medium text-gray-400 mt-6 mb-3">برای دسترسی به محتوای دوره، روی دکمه زیر کلیک کنید</span>

                            <div class="flex gap-4 flex-col">
                                @if($has_access)
                                <a href="{{ $lesson_one ? route('lesson.show', $lesson_one->slug) : '#' }}"
                                    class="cursor-pointer inline-flex items-center gap-3 w-full justify-center rounded-lg bg-green-500 border border-green-500 px-6 py-4 text-xl font-bold text-white hover:bg-green-600 hover:border-green-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-500 transition-all">
                                    مشاهده دوره و شروع یادگیری
                                </a>
                                @else
                                <button type="button" onclick="openCheckoutModal()"
                                    class="btn-arash cursor-pointer inline-flex items-center gap-3 w-full justify-center rounded-lg bg-blue-600 border border-blue-600 px-6 py-4 text-xl font-bold text-white hover:bg-blue-700 hover:border-blue-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-all">
                                    ثبت‌نام سریع و پرداخت
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="guest-checkout-modal" class="fixed inset-0 z-[70] hidden items-center justify-center p-4">
                <div class="absolute inset-0 bg-black/60" onclick="closeCheckoutModal()"></div>
                <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900">ثبت‌نام سریع دوره</h3>
                        <button type="button" onclick="closeCheckoutModal()" class="rounded-md p-1 text-gray-500 hover:bg-gray-100">✕</button>
                    </div>
                    <p class="mb-5 text-sm text-gray-600">مشخصات شما ثبت می‌شود و بعد از پرداخت، حساب کاربری و دسترسی دوره به صورت خودکار فعال خواهد شد.</p>

                    <form action="{{ route('course.checkout.zibal', $course->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">نام</label>
                                <input type="text" name="first_name" value="{{ $defaultFirstName }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-800 focus:border-blue-500 focus:outline-none">
                                @error('first_name')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">نام خانوادگی</label>
                                <input type="text" name="last_name" value="{{ $defaultLastName }}" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-800 focus:border-blue-500 focus:outline-none">
                                @error('last_name')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">شماره موبایل</label>
                            <input type="text" name="phone" value="{{ $defaultPhone }}" placeholder="09xxxxxxxxx" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-800 focus:border-blue-500 focus:outline-none">
                            @error('phone')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="btn-arash inline-flex w-full items-center justify-center rounded-lg bg-blue-600 px-4 py-3 text-sm font-bold text-white transition hover:bg-blue-700">
                            ادامه و انتقال به پرداخت
                        </button>
                    </form>
                </div>
            </div>

            <script>
                function openCheckoutModal() {
                    const modal = document.getElementById('guest-checkout-modal');
                    if (!modal) return;
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    document.body.classList.add('overflow-hidden');
                }

                function closeCheckoutModal() {
                    const modal = document.getElementById('guest-checkout-modal');
                    if (!modal) return;
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    document.body.classList.remove('overflow-hidden');
                }

                function resetAllVideos() {
                    document.querySelectorAll('video').forEach((videoElement) => {
                        if (!videoElement.paused) {
                            videoElement.pause();
                        }
                    });
                    document.querySelectorAll('.video-with-overlay').forEach((container) => {
                        const video = container.querySelector('video');
                        const overlay = container.querySelector('.overlay');
                        if (overlay) {
                            video.removeAttribute('controls');
                            overlay.style.display = 'flex';
                        }
                    });
                }

                document.querySelectorAll('.video-with-overlay').forEach((container) => {
                    const video = container.querySelector('video');
                    const overlay = container.querySelector('.overlay');
                    if (!overlay || !video) return;
                    overlay.addEventListener('click', () => {
                        resetAllVideos();
                        video.play();
                        video.setAttribute('controls', true);
                        overlay.style.display = 'none';
                    });
                    video.addEventListener('pause', () => {
                        video.removeAttribute('controls');
                        overlay.style.display = 'flex';
                    });
                    video.addEventListener('play', () => {
                        overlay.style.display = 'none';
                    });
                });

                document.addEventListener('DOMContentLoaded', function() {
                    @if($errors->has('first_name') || $errors->has('last_name') || $errors->has('phone'))
                    openCheckoutModal();
                    @endif

                    // Sticky Sidebar
                    const baseElement = document.querySelector('.video-with-overlay.base');
                    const sidebarElement = document.querySelector('.video-with-overlay.sidebar');
                    if (baseElement && sidebarElement) {
                        window.addEventListener('scroll', function() {
                            const scrollTop = window.scrollY;
                            const baseOffset = baseElement.getBoundingClientRect().top + window.scrollY;
                            if (scrollTop > baseOffset + 200) {
                                sidebarElement.classList.remove('opacity-0', 'invisible');
                            } else {
                                sidebarElement.classList.add('opacity-0', 'invisible');
                            }
                        });
                    }

                    // Countdown
                    function toPersianNumber(num) {
                        const persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
                        return num.toString().replace(/\d/g, (digit) => persianNumbers[digit]);
                    }

                    function updateCountdown() {
                        const countdownElement = document.querySelector('.countdown');
                        if (!countdownElement) return;

                        const countdownDate = new Date(countdownElement.dataset.date).getTime();
                        const now = new Date().getTime();
                        const distance = countdownDate - now;

                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        const dayEl = document.querySelector('.day');
                        const hourEl = document.querySelector('.hour');
                        const minuteEl = document.querySelector('.minute');
                        const secondEl = document.querySelector('.second');

                        if (dayEl && !isNaN(days)) dayEl.textContent = toPersianNumber(days);
                        if (hourEl && !isNaN(hours)) hourEl.textContent = toPersianNumber(hours);
                        if (minuteEl && !isNaN(minutes)) minuteEl.textContent = toPersianNumber(minutes);
                        if (secondEl && !isNaN(seconds)) secondEl.textContent = toPersianNumber(seconds);

                        if (days == 0 && dayEl) {
                            dayEl.parentElement.classList.add('hidden');
                            // Handle separators if they exist (custom logic needed if separators are separate elements)
                        } else if (dayEl) {
                            dayEl.parentElement.classList.remove('hidden');
                        }

                        if (distance < 0) {
                            clearInterval(x);
                            countdownElement.classList.add('hidden');
                        }
                    }

                    const x = setInterval(updateCountdown, 1000);
                    updateCountdown();

                    // Video Controls Click
                    document.querySelectorAll('video').forEach(video => {
                        video.addEventListener('click', function() {
                            if (!this.hasAttribute('controls')) {
                                this.setAttribute('controls', 'controls');
                                this.play();
                            }
                        });
                    });

                    // Truncate Toggle
                    document.querySelectorAll('.truncate-toggle').forEach(toggle => {
                        toggle.addEventListener('click', function() {
                            const wrapper = this.closest('.truncate-js');
                            const text = wrapper.querySelector('.truncate-text');
                            if (text) {
                                // Find class starting with line-clamp-
                                const classes = text.className.split(' ');
                                const lineClampClass = classes.find(c => c.startsWith('line-clamp-'));
                                if (lineClampClass) {
                                    text.classList.remove(lineClampClass);
                                    this.classList.add('hidden');
                                }
                            }
                        });
                    });
                });
            </script>
        </div>

        <!-- end container -->
    </main>


@endsection
