@extends('frontend.layouts.master')

@section('title', 'درباره ما | آرش فدایی')
@section('description', 'با آرش فدایی، خدمات توسعه وب، آموزش، مشاوره و مسیر کاری این مجموعه بیشتر آشنا شوید.')
@section('canonical', route('about.index'))

@section('content')
<main class="flex-auto py-8">
    <div class="max-w-7xl px-4 mx-auto space-y-10">
        <section class="relative overflow-hidden rounded-[2rem] border border-border bg-gradient-to-l from-secondary via-background to-background p-8 sm:p-12">
            <div class="absolute inset-y-0 left-0 w-1/3 bg-gradient-to-r from-primary/10 to-transparent pointer-events-none"></div>
            <div class="relative grid lg:grid-cols-2 gap-10 items-center">
                <div class="space-y-6">
                    <span class="inline-flex items-center gap-2 rounded-full bg-primary/10 px-4 py-2 text-primary text-sm font-bold">درباره ما</span>
                    <h1 class="text-3xl sm:text-5xl font-black text-foreground leading-tight">توسعه محصول، آموزش و محتوا با تمرکز روی کیفیت واقعی</h1>
                    <p class="text-sm sm:text-base leading-8 text-muted">
                        اینجا تمرکز فقط روی تولید یک سایت یا انتشار چند مقاله نیست. هدف ما ساخت تجربه‌ای است که هم برای کارفرما نتیجه‌محور باشد،
                        هم برای تیم محتوا و سئو قابل اتکا، و هم برای کاربران نهایی سریع، قابل فهم و حرفه‌ای به نظر برسد.
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('contact.index') }}" class="inline-flex items-center justify-center h-11 rounded-full bg-primary px-5 text-sm font-bold text-primary-foreground hover:opacity-80 transition-all">شروع همکاری</a>
                        <a href="{{ route('blog.index') }}" class="inline-flex items-center justify-center h-11 rounded-full bg-secondary px-5 text-sm font-bold text-foreground hover:text-primary transition-all">مطالعه مقالات</a>
                    </div>
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="rounded-3xl bg-background border border-border p-6 space-y-3">
                        <div class="text-primary text-sm font-black">مسیر کاری</div>
                        <p class="text-sm text-muted leading-7">تحلیل نیاز، طراحی تجربه، پیاده‌سازی، بهینه‌سازی فنی و تحویل قابل توسعه.</p>
                    </div>
                    <div class="rounded-3xl bg-background border border-border p-6 space-y-3">
                        <div class="text-primary text-sm font-black">تمرکز فنی</div>
                        <p class="text-sm text-muted leading-7">Laravel، PHP، بهینه‌سازی فرانت، سئو تکنیکال و ساخت پنل‌های کاربردی.</p>
                    </div>
                    <div class="rounded-3xl bg-background border border-border p-6 space-y-3">
                        <div class="text-primary text-sm font-black">برای تیم محتوا</div>
                        <p class="text-sm text-muted leading-7">ویرایشگر مناسب تولید محتوا، ساختار درست مقاله و پشتیبانی از کد و مدیا.</p>
                    </div>
                    <div class="rounded-3xl bg-background border border-border p-6 space-y-3">
                        <div class="text-primary text-sm font-black">برای کسب‌وکار</div>
                        <p class="text-sm text-muted leading-7">تمرکز روی پرفورمنس، نرخ تبدیل، نگهداری ساده و تصمیم‌های مقیاس‌پذیر.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid lg:grid-cols-3 gap-6">
            <div class="rounded-3xl border border-border bg-background p-8 space-y-4">
                <h2 class="text-xl font-black text-foreground">نگاه ما به پروژه</h2>
                <p class="text-sm text-muted leading-8">
                    هر پروژه باید هم از نظر فنی سالم باشد، هم از نظر تجربه کاربری قابل دفاع، و هم از نظر سئو پایه‌های درستی داشته باشد.
                    به همین دلیل تصمیم‌ها فقط بر اساس ظاهر یا صرفاً سرعت تحویل گرفته نمی‌شوند.
                </p>
            </div>
            <div class="rounded-3xl border border-border bg-background p-8 space-y-4">
                <h2 class="text-xl font-black text-foreground">نگاه ما به آموزش</h2>
                <p class="text-sm text-muted leading-8">
                    آموزش خوب باید اجرایی، به‌روز و قابل استفاده در پروژه واقعی باشد. مقالات و محتوا هم باید برای انسان نوشته شوند، نه فقط برای موتور جستجو.
                </p>
            </div>
            <div class="rounded-3xl border border-border bg-background p-8 space-y-4">
                <h2 class="text-xl font-black text-foreground">نگاه ما به همکاری</h2>
                <p class="text-sm text-muted leading-8">
                    ارتباط شفاف، تحویل مرحله‌ای و امکان توسعه آینده برای ما اهمیت زیادی دارد. همکاری خوب یعنی همه بدانند چرا هر تصمیم گرفته شده است.
                </p>
            </div>
        </section>
    </div>
</main>
@endsection
