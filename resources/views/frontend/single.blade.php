@extends('frontend.layouts.master')

            @section('title', $post->title)
@section('content')


    <main class="flex-auto py-5">


            <!-- container -->
            <div class="max-w-7xl space-y-14 px-4 mx-auto">
                <div class="flex md:flex-nowrap flex-wrap items-start gap-5">
                    <div class="md:w-8/12 w-full">
                        <div class="relative">
                            <!-- article:thumbnail -->
                            <div class="relative z-10">
                                <img src="{{ asset('storage/') }}/{{ $post->thumbnail }}" class="max-w-full rounded-3xl"
                                    alt="..." />
                            </div>

                            <div class="-mt-12 pt-12">
                                <div class="bg-gradient-to-b from-background to-secondary rounded-b-3xl space-y-2 p-5 mx-5">
                                    <!-- article:title -->
                                    <h1 class="font-bold text-xl text-foreground">{{ $post->title }}</h1>

                                    {{-- <!-- article:excerpt -->
                                    <p class="text-sm text-muted">


                                    </p> --}}
                                </div>
                                <div class="space-y-10 py-5">
                                    <!-- article:description -->
                                    <div class="description">

                                        {!! $post->body !!}
                                    </div>
                                    <!-- end article:description -->

                                    <!-- article:comments:container -->
                                    @include('frontend.partials.single-blog.comments')

                                    <!-- end article:comments:container -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="md:w-4/12 w-full md:sticky md:top-24 space-y-8">
                        <div class="space-y-5">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center gap-1">
                                    <div class="w-1 h-1 bg-foreground rounded-full"></div>
                                    <div class="w-2 h-2 bg-foreground rounded-full"></div>
                                </div>
                                <div class="font-black text-sm text-foreground">نویسنده:</div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full overflow-hidden">
                                        <img src="{{ asset('storage') }}/{{ $post->user->avatar }}"
                                            class="w-full h-full object-cover" alt="{{ $post->user->name }}" />
                                    </div>
                                    <div class="flex flex-col items-start space-y-1">
                                        <a href="./lecturer.html"
                                            class="line-clamp-1 font-bold text-sm text-foreground hover:text-primary">{{ $post->user->name }}
                                        </a>

                                    </div>
                                </div>
                                <div class="bg-secondary rounded-tl-3xl rounded-b-3xl text-sm text-muted p-5">

                                    {{ $post->user->bio }}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end container -->

    </main>


@endsection
