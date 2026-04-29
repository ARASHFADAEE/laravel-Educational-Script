<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('frontend/css/swiper-bundle.min.css') }}" />
    @if (request()->routeIs('courses.show'))
    <script src="{{asset('frontend/js/jquery.min.js')}}"></script>
    @endif
    <script src="{{asset('frontend/js/toastify.js')}}"></script>
    <link rel="stylesheet" href="{{asset('frontend/css/toastify.css')}}">
    <meta name="google-site-verification" content="MgW3lz_6i6mhWBdcYQggX1h0OK2RIRIpACTPY3CFqt8" />




    <meta name="theme-color" content="#22C55E">
    <title>@yield('title')</title>
    <meta name="description"
        content="@yield('description')">
    <meta name="robots" content="follow, index, max-snippet:-1, max-video-preview:-1, max-image-preview:large">
    <link rel="canonical" href="@yield('canonical')">
    <meta property="og:locale" content="fa_IR">
    <meta property="og:type" content="@yield('type')">
    <meta property="og:title" content="@yield('og-title')">
    <meta property="og:description"
        content="@yield('og-description')">
    <meta property="og:url" content="@yield('canonical')">
    <meta property="og:site_name" content="{{env('APP_NAME')}}">
    <meta property="og:updated_time" content="2024-12-30T19:54:25+03:30">
    <meta property="og:image"
        content="@yield('og-img')">
    <meta property="og:image:secure_url"
        content="@yield('og-img')">
    <meta property="og:image:width" content="1024">
    <meta property="og:image:height" content="1024">
    <meta property="og:image:alt" content="@yield('title')">
    <meta property="og:image:type" content="image/png">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter-title')">
    <meta name="twitter:description"
        content="@yield('twitter-description')">
    <meta name="twitter:image"
        content="@yield('twitter-img')">


<meta property="article:published_time" content="@yield('article:published_time')">
<meta property="article:modified_time" content="@yield('article:modified_time')">
<meta property="article:author" content="@yield('article:author')">
<meta name="twitter:label1" content="@yield('twitter:label1')">
<meta name="twitter:data1" content="@yield('twitter:data1')">
<meta name="twitter:label2" content="@yield('twitter:label2')">
<meta name="twitter:data2" content="@yield('twitter:data2')">

    <link rel="icon" href="{{asset('image/icon/favicon.webp')}}"
        sizes="32x32">
    <link rel="icon" href="{{asset('image/icon/favicon.webp')}}"
        sizes="192x192">
    <link rel="apple-touch-icon" href="{{asset('image/icon/favicon.webp')}}">
    <meta name="msapplication-TileImage"
        content="{{asset('image/icon/favicon.webp')}}">






</head>

<body>

    <div class="flex flex-col min-h-screen bg-background">
        <!-- header -->
        @include('frontend.layouts.partials.header')

        <!-- end header -->


        @yield('content')



        <!-- footer -->
        @include('frontend.layouts.partials.footer')
        <!-- end footer -->

    </div>


    <script src="{{ asset('frontend/js/alpinejs.min.js') }}"></script>
    <script src="{{ asset('frontend/js/swiper-bundle.min.js') }}"></script>
    @if (request()->routeIs('lesson.show') || request()->routeIs('course.show') )

        <script src="{{ asset('frontend/js/plyr.min.js') }}"></script>

    @endif
    @if (session('success'))
        <script>
            Toastify({
                text: "{{ session('success') }}", // یا متن ثابت: "ورود موفقیت آمیز بود"
                duration: 2000, // اختیاری: زمان نمایش (میلی‌ثانیه)
                gravity: "top", // اختیاری: top یا bottom
                position: "right", // اختیاری: right, left, center
                className: "info",
                style: {
                    background: "green",
                }
            }).showToast();
        </script>
    @endif
    @if (session('error'))
        <script >
            Toastify({
                text: "{{ session('error') }}", // یا متن ثابت: "ورود موفقیت آمیز بود"
                duration: 2000, // اختیاری: زمان نمایش (میلی‌ثانیه)
                gravity: "top", // اختیاری: top یا bottom
                position: "right", // اختیاری: right, left, center
                className: "info",
                style: {
                    background: "red",
                }
            }).showToast();
        </script>
    @endif

    <script>
        document.addEventListener('alpine:init', () => {
            // تعریف یک تابع جستجو
            window.searchProducts = function(searchTerm) {
                if (searchTerm.length < 2) {
                    document.getElementById('search-results').innerHTML = '';
                    return;
                }

                fetch(`/Search?q=${encodeURIComponent(searchTerm)}`)
                    .then(response => response.json())
                    .then(data => {
                        let html = '';

                        if (data.length > 0) {
                            data.forEach(item => {
                                html += `
                            <div class="p-4 border-b hover:bg-gray-50">
                                <a href="/courses/${item.slug}" class="text-blue-600 hover:underline">
                                    ${item.title}
                                </a>
                            </div>`;
                            });
                        } else {
                            html = '<div class="p-4 text-center text-gray-500">هیچ نتیجه‌ای یافت نشد</div>';
                        }

                        document.getElementById('search-results').innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        document.getElementById('search-results').innerHTML =
                            '<div class="p-4 text-center text-red-500">خطا در جستجو</div>';
                    });
            };
        });
    </script>

    @yield('schema')









</body>

</html>
