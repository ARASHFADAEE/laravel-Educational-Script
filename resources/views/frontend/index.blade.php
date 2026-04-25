@extends('frontend.layouts.master')

@section('title', 'آرش فدایی - توسعه‌دهنده ارشد وب و متخصص PHP')
@section('description', 'آرش فدایی توسعه دهنده فول استک و موسس سایت ملودی من یک سایت موزیک ایرانی با قابلیت های جذاب')
@section('canonical',url()->current())

@section('content')
    <main class="flex-auto py-5">



        <div class="space-y-14">
            <!-- container -->
            <div class="max-w-7xl space-y-14 px-4 mx-auto">
                <!-- intro -->
                @include('frontend.partials.Home.intro')

                <!-- end intro -->



                <!-- section:latest-courses -->
                @include('frontend.partials.Home.latest-courses',["courses"=>$courses])


                <!-- end section:latest-courses -->
            </div>
            <!-- end container -->

            <!-- feedback -->
            @include('frontend.partials.Home.feedback')

            <!-- end feedback -->

            <!-- container -->
            <div class="max-w-7xl space-y-14 px-4 mx-auto rounded-lg">
                <!-- articles -->
                @include('frontend.partials.Home.articles',["posts"=>$posts])
                <!-- end articles -->
            </div>
            <!-- end container -->
        </div>
    </main>


@endsection
