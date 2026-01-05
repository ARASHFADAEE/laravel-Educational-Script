@extends('frontend.layouts.master')

@section('title', '- صفحه اصلی ض')
@section('content')
        <main class="flex-auto py-5">
            <div class="space-y-14">
                <!-- container -->
                <div class="max-w-7xl space-y-14 px-4 mx-auto">
                    <!-- intro -->
                    @include('frontend.partials.Home.intro')

                    <!-- end intro -->

                    <!-- features -->
                    @include('frontend.partials.Home.features')

                    <!-- end features -->

                    <!-- section:latest-courses -->
                    @include('frontend.partials.Home.latest-courses')

                    <!-- end section:latest-courses -->
                </div>
                <!-- end container -->

                <!-- feedback -->
                @include('frontend.partials.Home.feedback')

                <!-- end feedback -->

                <!-- container -->
                <div class="max-w-7xl space-y-14 px-4 mx-auto">
                    <!-- articles -->
                    @include('frontend.partials.Home.articles')
                    <!-- end articles -->
                </div>
                <!-- end container -->
            </div>
        </main>


@endsection