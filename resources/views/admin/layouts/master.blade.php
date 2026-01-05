<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')-پنل ادمین</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-gray-100 transition-colors duration-300">

    <!-- Sidebar -->
    @include('admin.layouts.partials.sidebar')


    <!-- Main Content -->

    @yield('main')



</body>

      