@extends('frontend.layouts.master')



@section('title', 'داشبورد')


@section('content')


    <main class="flex-auto py-5">
        <div class="max-w-7xl space-y-14 px-4 mx-auto">
            <div class="grid md:grid-cols-12 grid-cols-1 items-start gap-5">
                <div class="lg:col-span-3 md:col-span-4 md:sticky md:top-24">
                    <!-- user:info -->
                    <div class="flex items-center gap-5 mb-5">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full overflow-hidden">
                                <img src="{{asset('image/avatar/avatar.png')}}" class="w-full h-full object-cover" alt="..." />
                            </div>
                            <div class="flex flex-col items-start space-y-1">
                                <span class="text-xs text-muted">خوش آمدید</span>
                                <span class="line-clamp-1 font-semibold text-sm text-foreground cursor-default">
                                   {{Auth()->user()->name}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- end user:info -->

                    <!-- user:menus -->
                    @include('user.partials.menu')

                    <!-- end user:menus -->
                </div>

                <div class="lg:col-span-9 md:col-span-8">
                    <div class="space-y-10">
                        <!-- statistics:items:wrapper -->
                        @include('user.partials.statistics')

                        <!-- end statistics:wrapper -->

                        <!-- section:learning-courses -->
                        @yield('content-dashboard')
                       
                        <!-- end section:learning-courses -->
                    </div>
                </div>
            </div>
        </div>
    </main>


@endsection
