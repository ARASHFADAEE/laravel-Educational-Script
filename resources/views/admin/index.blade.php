<!DOCTYPE html>
<html lang="fa" dir="rtl" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل ادمین</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-primary-light dark:bg-primary-dark text-primary-light dark:text-primary-dark flex h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-secondary-light dark:bg-secondary-dark p-4 flex flex-col">
        <h2 class="text-2xl font-bold mb-6 text-accent">پنل ادمین</h2>
        <nav class="flex flex-col gap-2">
            <a href="#" class="px-4 py-2 rounded hover:bg-accent-light hover:text-white dark:hover:bg-accent-dark dark:hover:text-white transition">داشبورد</a>
            <a href="#" class="px-4 py-2 rounded hover:bg-accent-light hover:text-white dark:hover:bg-accent-dark dark:hover:text-white transition">کاربران</a>
            <a href="#" class="px-4 py-2 rounded hover:bg-accent-light hover:text-white dark:hover:bg-accent-dark dark:hover:text-white transition">دوره‌ها</a>
            <a href="#" class="px-4 py-2 rounded hover:bg-accent-light hover:text-white dark:hover:bg-accent-dark dark:hover:text-white transition">مقالات</a>
            <a href="#" class="px-4 py-2 rounded hover:bg-accent-light hover:text-white dark:hover:bg-accent-dark dark:hover:text-white transition">پرداخت‌ها</a>
            <a href="#" class="px-4 py-2 rounded hover:bg-accent-light hover:text-white dark:hover:bg-accent-dark dark:hover:text-white transition">نظرات</a>
            <a href="#" class="px-4 py-2 rounded hover:bg-accent-light hover:text-white dark:hover:bg-accent-dark dark:hover:text-white transition">تنظیمات SEO</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 overflow-auto">
        <!-- Header -->
        <header class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-accent">داشبورد</h1>
            <button id="dark-toggle" class="px-4 py-2 bg-accent-light text-white rounded hover:bg-accent-dark transition">تغییر تم</button>
        </header>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-secondary-light dark:bg-secondary-dark p-4 rounded shadow">
                <h2 class="text-muted mb-2">تعداد کاربران</h2>
                <p class="text-2xl font-bold">120</p>
            </div>
            <div class="bg-secondary-light dark:bg-secondary-dark p-4 rounded shadow">
                <h2 class="text-muted mb-2">دوره‌ها</h2>
                <p class="text-2xl font-bold">25</p>
            </div>
            <div class="bg-secondary-light dark:bg-secondary-dark p-4 rounded shadow">
                <h2 class="text-muted mb-2">پرداخت‌های موفق</h2>
                <p class="text-2xl font-bold">75</p>
            </div>
        </div>

        <!-- Users Table -->
        <section class="mb-6">
            <h2 class="text-xl font-bold mb-4 text-accent">لیست کاربران</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-secondary-light dark:bg-secondary-dark">
                        <tr>
                            <th class="px-4 py-2 text-muted">#</th>
                            <th class="px-4 py-2 text-muted">نام</th>
                            <th class="px-4 py-2 text-muted">ایمیل</th>
                            <th class="px-4 py-2 text-muted">نقش</th>
                            <th class="px-4 py-2 text-muted">اقدامات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-300 dark:border-gray-700">
                            <td class="px-4 py-2">1</td>
                            <td class="px-4 py-2">آرش فدایی</td>
                            <td class="px-4 py-2">arash@example.com</td>
                            <td class="px-4 py-2">admin</td>
                            <td class="px-4 py-2">
                                <button class="px-2 py-1 bg-accent-light text-white rounded hover:bg-accent-dark transition">ویرایش</button>
                                <button class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">حذف</button>
                            </td>
                        </tr>
                        <tr class="border-b border-gray-300 dark:border-gray-700">
                            <td class="px-4 py-2">2</td>
                            <td class="px-4 py-2">مریم حسینی</td>
                            <td class="px-4 py-2">maryam@example.com</td>
                            <td class="px-4 py-2">student</td>
                            <td class="px-4 py-2">
                                <button class="px-2 py-1 bg-accent-light text-white rounded hover:bg-accent-dark transition">ویرایش</button>
                                <button class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">حذف</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Courses Table -->
        <section>
            <h2 class="text-xl font-bold mb-4 text-accent">لیست دوره‌ها</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-secondary-light dark:bg-secondary-dark">
                        <tr>
                            <th class="px-4 py-2 text-muted">#</th>
                            <th class="px-4 py-2 text-muted">عنوان دوره</th>
                            <th class="px-4 py-2 text-muted">قیمت</th>
                            <th class="px-4 py-2 text-muted">سطح</th>
                            <th class="px-4 py-2 text-muted">وضعیت</th>
                            <th class="px-4 py-2 text-muted">اقدامات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-300 dark:border-gray-700">
                            <td class="px-4 py-2">1</td>
                            <td class="px-4 py-2">PHP پیشرفته</td>
                            <td class="px-4 py-2">1,500,000</td>
                            <td class="px-4 py-2">پیشرفته</td>
                            <td class="px-4 py-2">منتشر شده</td>
                            <td class="px-4 py-2">
                                <button class="px-2 py-1 bg-accent-light text-white rounded hover:bg-accent-dark transition">ویرایش</button>
                                <button class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">حذف</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script>
        const toggle = document.getElementById('dark-toggle');
        toggle.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
        });
    </script>

</body>
</html>
