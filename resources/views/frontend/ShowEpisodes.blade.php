@extends('frontend.layouts.master')


@section('title', 'مشاهده دوره')


@section('content')


    <main class="flex-auto py-5">

        <!-- container -->
        <div class="max-w-7xl space-y-14 px-4 mx-auto">
            <div class="flex lg:flex-nowrap flex-wrap items-start gap-5">
                <div class="lg:w-8/12 w-full">
                    <!-- section:title -->
                    <div class="flex items-center gap-5 mb-5">
                        <!-- back to course -->
                        <a href="{{ Route('course.show', $course->slug) }}"
                            class="flex items-center justify-center w-12 h-12 bg-primary text-primary-foreground rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m15 15 6-6m0 0-6-6m6 6H9a6 6 0 0 0 0 12h3" />
                            </svg>
                        </a>
                        <div class="flex flex-col space-y-2">
                            <!-- episode:title -->
                            <span class="font-black text-2xl text-primary">{{ $lesson->title }}</span>
                            <!-- course:title -->
                            <span class="font-semibold text-xs text-muted">{{ $course->name }}</span>
                        </div>
                    </div>
                    <!-- end section:title -->

                    <!-- episode:video:wrapper -->
                    <div class="relative max-w-full rounded-3xl overflow-hidden z-10">
                        <video class="js-player" playsinline controls data-poster="{{asset('storage')}}/{{$course->thumbnail}}">
                            <source src="{{ $lesson->video_url }}" type="video/mp4" />

                        </video>
                    </div>
                    <!-- end episode:video:wrapper -->
                </div>
                <div class="lg:w-4/12 w-full lg:sticky lg:top-24 space-y-8">
                    <div class="bg-background rounded-2xl">
                        <!-- course:sections:wrapper -->
                        <div class="flex flex-col space-y-1">
                            @foreach($chapters as $chapter)

                            <!-- course:section:accordion -->
                            <div class="w-full space-y-1" x-data="{ open: false }">
                                <!-- accordion:button -->
                                <button type="button"
                                    class="w-full h-14 flex items-center justify-between gap-x-2 relative bg-secondary rounded-2xl transition hover:text-foreground px-5"
                                    x-bind:class="open ? 'text-foreground' : 'text-muted'" x-on:click="open = !open">
                                    <span class="flex items-center gap-3 text-right">
                                        <span class="font-semibold text-xs line-clamp-1">
                                            {{$chapter->title}}</span>
                                        <div class="w-1 h-1 bg-muted-foreground rounded-full"></div>
                                    </span>
                                    <span class="" x-bind:class="open ? 'rotate-180' : ''">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                                        </svg>
                                    </span>
                                </button>
                                <!-- end accordion:button -->

                                <!-- accordion:content -->
                                <div class="flex flex-col relative" x-show="open">
                                    <!-- course:section:episodes:wrapper -->
                                    <div class="bg-background border border-border rounded-2xl space-y-1 overflow-hidden">
                                        @php
                                            $i=1
                                        @endphp
                                        @foreach ($chapter->lessons as $lesson)
                                            <div
                                                class="flex sm:flex-nowrap flex-wrap items-center @if (request()->slug == $lesson->slug) bg-primary text-primary-foreground text-white @endif  gap-3 sm:h-12 p-5 " >
                                                <span class="text-xs text-muted">{{$i++}}</span>
                                                <div class="w-1 h-1 bg-muted-foreground rounded-full"></div>
                                                <a href="{{ route('lesson.show', $lesson->slug) }}"
                                                    class="font-semibold text-xs text-foreground line-clamp-1 transition-all hover:underline "@if (request()->slug == $lesson->slug) style="color:#ffff !important" @endif>
                                                    {{ $lesson->title }}
                                                </a>
                                                <div class="flex items-center justify-end gap-3 sm:w-auto w-full mr-auto">
                                                    <span class="flex items-center gap-1 text-muted">
                                                        <span class="text-xs" @if (request()->slug == $lesson->slug) style="color:#ffff !important" @endif>۰۳:۵۸</span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                    @if (request()->slug != $lesson->slug)
                                                    <a href="{{ route('lesson.show', $lesson->slug) }}"
                                                        class="flex items-center h-9 gap-1 bg-secondary rounded-full text-muted transition-colors hover:text-primary px-4">
                                                        <span class="text-xs">مشاهده</span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-5 h-5">
                                                            <path fill-rule="evenodd"
                                                                d="M14.78 14.78a.75.75 0 0 1-1.06 0L6.5 7.56v5.69a.75.75 0 0 1-1.5 0v-7.5A.75.75 0 0 1 5.75 5h7.5a.75.75 0 0 1 0 1.5H7.56l7.22 7.22a.75.75 0 0 1 0 1.06Z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach


                                    </div>
                                    <!-- end course:section:episodes:wrapper -->
                                </div>

                                <!-- end accordion:content -->
                            </div>
                            @endforeach

                            <!-- end course:section:accordion -->

                        </div>
                        <!-- end course:sections:wrapper -->
                    </div>
                </div>
            </div>
            <div class="flex md:flex-nowrap flex-wrap items-start gap-5">
                <div class="md:w-8/12 w-full">
                    <div class="relative">
                        <div class="space-y-10">
                            <!-- tabs container -->
                            <div class="space-y-5" x-data="{ activeTab: 'tabOne', scroll: function() { document.getElementById(this.activeTab).scrollIntoView({ behavior: 'smooth' }) } }">
                                <div class="sticky top-24 z-10">
                                    <!-- tabs:list-container -->
                                    <div class="relative overflow-x-auto">
                                        <!-- tabs:list -->
                                        <ul class="inline-flex gap-2 bg-secondary border border-border rounded-full p-1">
                                            <!-- tabs:list:item -->
                                            <li>
                                                <button type="button"
                                                    class="flex items-center gap-x-2 relative rounded-full py-2 px-4"
                                                    x-bind:class="activeTab === 'tabOne' ? 'text-foreground bg-background' :
                                                        'text-muted'"
                                                    x-on:click="activeTab = 'tabOne'; scroll();">
                                                    <!-- active icon -->
                                                    <span x-show="activeTab === 'tabOne'">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-5 h-5">
                                                            <path
                                                                d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                    <!-- end active icon -->

                                                    <!-- inactive icon -->
                                                    <span x-show="activeTab !== 'tabOne'">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                    <!-- end inactive icon -->

                                                    <span class="font-semibold text-sm whitespace-nowrap">توضیحات</span>
                                                </button>
                                            </li>
                                            <!-- end tabs:list:item -->

                                            <!-- tabs:list:item -->
                                            <li>
                                                <button type="button"
                                                    class="flex items-center gap-x-2 relative rounded-full py-2 px-4"
                                                    x-bind:class="activeTab === 'tabTwo' ? 'text-foreground bg-background' :
                                                        'text-muted'"
                                                    x-on:click="activeTab = 'tabTwo'; scroll();">
                                                    <!-- active icon -->
                                                    <span x-show="activeTab === 'tabTwo'">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-5 h-5">
                                                            <path
                                                                d="M3.505 2.365A41.369 41.369 0 0 1 9 2c1.863 0 3.697.124 5.495.365 1.247.167 2.18 1.108 2.435 2.268a4.45 4.45 0 0 0-.577-.069 43.141 43.141 0 0 0-4.706 0C9.229 4.696 7.5 6.727 7.5 8.998v2.24c0 1.413.67 2.735 1.76 3.562l-2.98 2.98A.75.75 0 0 1 5 17.25v-3.443c-.501-.048-1-.106-1.495-.172C2.033 13.438 1 12.162 1 10.72V5.28c0-1.441 1.033-2.717 2.505-2.914Z">
                                                            </path>
                                                            <path
                                                                d="M14 6c-.762 0-1.52.02-2.271.062C10.157 6.148 9 7.472 9 8.998v2.24c0 1.519 1.147 2.839 2.71 2.935.214.013.428.024.642.034.2.009.385.09.518.224l2.35 2.35a.75.75 0 0 0 1.28-.531v-2.07c1.453-.195 2.5-1.463 2.5-2.915V8.998c0-1.526-1.157-2.85-2.729-2.936A41.645 41.645 0 0 0 14 6Z">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                    <!-- end active icon -->

                                                    <!-- inactive icon -->
                                                    <span x-show="activeTab !== 'tabTwo'">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                    <!-- end inactive icon -->

                                                    <span class="font-semibold text-sm whitespace-nowrap">دیدگاه و
                                                        پرسش</span>
                                                </button>
                                            </li>
                                            <!-- end tabs:list:item -->
                                        </ul>
                                        <!-- end tabs:list -->
                                    </div>
                                    <!-- end tabs:list-container -->
                                </div>

                                <!-- tabs:contents -->
                                <div class="space-y-8">
                                    <!-- tabs:contents:tabOne -->
                                    <div class="bg-background rounded-3xl p-5" id="tabOne">
                                        <!-- episode:description -->
                                        <div class="description">

                                            <h2>دوره آموزشی پروژه محور react و next</h2>

                                        </div>
                                        <!-- end episode:description -->
                                    </div>
                                    <!-- end tabs:contents:tabOne -->


                                </div>
                                <!-- end tabs:contents -->
                            </div>
                            <!-- end tabs container -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- end container -->

    </main>

@endsection
