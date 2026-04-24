@extends('frontend.layouts.master')

@section('title', 'تماس با ما | آرش فدایی')
@section('description', 'برای مشاوره، ثبت درخواست پروژه، همکاری یا دریافت اطلاعات بیشتر با ما در ارتباط باشید.')
@section('canonical', route('contact.index'))

@section('content')
<main class="flex-auto py-8">
    <div class="max-w-7xl px-4 mx-auto space-y-10">
        <section class="grid lg:grid-cols-5 gap-6">
            <div class="lg:col-span-2 rounded-[2rem] border border-border bg-gradient-to-b from-secondary to-background p-8 space-y-6">
                <div class="space-y-3">
                    <span class="inline-flex rounded-full bg-primary/10 px-4 py-2 text-sm font-bold text-primary">تماس و ثبت درخواست</span>
                    <h1 class="text-3xl sm:text-4xl font-black text-foreground">برای شروع پروژه یا دریافت مشاوره اینجاییم</h1>
                    <p class="text-sm leading-8 text-muted">
                        اگر برای طراحی و توسعه سایت، بهبود پرفورمنس، سئو تکنیکال یا تولید محتوای فنی برنامه دارید، از همین فرم شروع کنیم.
                    </p>
                </div>

                <div class="space-y-4">
                    <div class="rounded-2xl border border-border bg-background p-5">
                        <div class="text-sm font-black text-primary">ایمیل</div>
                        <div class="mt-2 text-sm text-foreground">hello@example.com</div>
                    </div>
                    <div class="rounded-2xl border border-border bg-background p-5">
                        <div class="text-sm font-black text-primary">شماره تماس</div>
                        <div class="mt-2 text-sm text-foreground">۰۲۱-۱۲۳۴۵۶۷۸</div>
                    </div>
                    <div class="rounded-2xl border border-border bg-background p-5">
                        <div class="text-sm font-black text-primary">ساعت پاسخ‌گویی</div>
                        <div class="mt-2 text-sm text-foreground">شنبه تا چهارشنبه، ۹ تا ۱۷</div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-3 rounded-[2rem] border border-border bg-background p-6 sm:p-8">
                <form action="{{ route('contact.index') }}" method="POST" class="grid sm:grid-cols-2 gap-4">
                    @csrf
                    <div>
                        <label class="block mb-2 text-sm font-bold text-foreground">نام و نام خانوادگی</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-input w-full rounded-2xl border-border bg-secondary/40" required>
                        @error('name')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-bold text-foreground">ایمیل</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-input w-full rounded-2xl border-border bg-secondary/40" required>
                        @error('email')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-bold text-foreground">شماره تماس</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-input w-full rounded-2xl border-border bg-secondary/40">
                        @error('phone')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-bold text-foreground">موضوع</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" class="form-input w-full rounded-2xl border-border bg-secondary/40" required>
                        @error('subject')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-bold text-foreground">نوع درخواست</label>
                        <select name="project_type" class="form-input w-full rounded-2xl border-border bg-secondary/40">
                            <option value="">انتخاب کنید</option>
                            @foreach (['طراحی سایت', 'توسعه با لاراول', 'سئو تکنیکال', 'مشاوره فنی', 'بهینه‌سازی سایت'] as $option)
                                <option value="{{ $option }}" @selected(old('project_type') === $option)>{{ $option }}</option>
                            @endforeach
                        </select>
                        @error('project_type')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-bold text-foreground">بازه بودجه</label>
                        <select name="budget" class="form-input w-full rounded-2xl border-border bg-secondary/40">
                            <option value="">انتخاب کنید</option>
                            @foreach (['کمتر از ۳۰ میلیون', '۳۰ تا ۷۰ میلیون', '۷۰ تا ۱۵۰ میلیون', 'بیشتر از ۱۵۰ میلیون'] as $option)
                                <option value="{{ $option }}" @selected(old('budget') === $option)>{{ $option }}</option>
                            @endforeach
                        </select>
                        @error('budget')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block mb-2 text-sm font-bold text-foreground">شرح درخواست</label>
                        <textarea name="message" rows="7" class="form-input w-full rounded-3xl border-border bg-secondary/40" required>{{ old('message') }}</textarea>
                        @error('message')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div class="sm:col-span-2 flex flex-wrap items-center gap-3">
                        <button type="submit" class="inline-flex items-center justify-center h-12 rounded-full bg-primary px-6 text-sm font-bold text-primary-foreground hover:opacity-80 transition-all">ثبت درخواست پروژه</button>
                        <span class="text-xs text-muted">پس از ثبت فرم، اطلاعات شما برای پیگیری در همین سیستم اعتبارسنجی می‌شود و پیام موفقیت نمایش داده خواهد شد.</span>
                    </div>
                </form>
            </div>
        </section>
    </div>
</main>
@endsection
