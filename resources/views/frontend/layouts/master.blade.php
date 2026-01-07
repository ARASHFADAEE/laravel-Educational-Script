<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{asset('images/favicon.svg')}}" />
     @vite(['resources/css/app.css', 'resources/js/app.js'])
     <link rel="stylesheet" href="{{asset('frontend/css/swiper-bundle.min.css')}}" />
     <link rel="stylesheet" href="{{asset('frontend/css/toastify.css')}}">
     <link rel="stylesheet" href="{{asset('frontend/css/plyr.min.css')}}">
     <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <title>@yield('title')</title>
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

    <script src="{{asset('frontend/js/toastify.js')}}"></script>

<script src="{{asset('frontend/js/alpinejs.min.js')}}"></script>
<script src="{{asset('frontend/js/swiper-bundle.min.js')}}"></script>
<script src="{{asset('frontend/js/plyr.min.js')}}"></script>
@if (session('success'))
    <script>
        Toastify({
            text: "{{ session('success') }}",  // یا متن ثابت: "ورود موفقیت آمیز بود"
            duration: 2000,  // اختیاری: زمان نمایش (میلی‌ثانیه)
            gravity: "top",   // اختیاری: top یا bottom
            position: "right", // اختیاری: right, left, center
            className: "info",
            style: {
                background: "green",
            }
        }).showToast();




    </script>


@endif

<script>
    jQuery("#SearchKey").on('keyup', function () { 
    let query = jQuery(this).val();

    if(query.length < 2) return; 


    jQuery.ajax({
        url: '/Search', 
        method: 'GET',
        data: { q: query },
        success: function(response) {

            let html = '';

            if(response.length > 0){
                response.forEach(item => {
                    html += `<div class="p-7 ">
                                <a href="/blog/${item.slug}">${item.title}</a>
                             </div>`;
                });
            } else {
                html = '<div>هیچ نتیجه‌ای یافت نشد</div>';
            }

            jQuery('#search-results').html(html);
        }
    });
});
</script>

</body>

</html>