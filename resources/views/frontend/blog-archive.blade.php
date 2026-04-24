@extends('frontend.layouts.master')

@section('title', 'آرشیو مقالات | آرش فدایی')
@section('description', 'آرشیو مقالات آموزشی با قابلیت جستجو و فیلتر بر اساس دسته‌بندی.')
@section('canonical', route('blog.index', request()->query()))

@section('content')
<main class="flex-auto py-8">
    <div class="max-w-7xl px-4 mx-auto space-y-8">
        <section class="rounded-[2rem] border border-border bg-gradient-to-l from-secondary to-background p-8 sm:p-10 space-y-4">
            <span class="inline-flex rounded-full bg-primary/10 px-4 py-2 text-sm font-bold text-primary">آرشیو مقالات</span>
            <div class="flex flex-col lg:flex-row lg:items-end gap-6 justify-between">
                <div class="space-y-3 max-w-3xl">
                    <h1 class="text-3xl sm:text-5xl font-black text-foreground">مقالات آموزشی با فیلتر و جستجوی سریع</h1>
                    <p class="text-sm sm:text-base text-muted leading-8">دسته‌بندی موردنظر را انتخاب کنید، عنوان مقاله را جستجو کنید و سریع‌تر به محتوای مناسب برسید.</p>
                </div>
                <div class="rounded-2xl bg-background border border-border px-5 py-4 text-sm text-muted">
                    {{ $posts->total() }} مقاله پیدا شد
                </div>
            </div>
        </section>

        <section class="grid lg:grid-cols-12 gap-6 items-start">
            <aside class="lg:col-span-3 space-y-4 lg:sticky lg:top-24">
                <form action="{{ route('blog.index') }}" method="GET" class="rounded-3xl border border-border bg-background p-5 space-y-4">
                    <div>
                        <label class="block mb-2 text-sm font-black text-foreground">جستجو</label>
                        <input type="text" name="q" value="{{ $search }}" class="form-input w-full rounded-2xl border-border bg-secondary/40" placeholder="عنوان یا بخشی از متن مقاله">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-black text-foreground">دسته‌بندی</label>
                        <select name="category" class="form-input w-full rounded-2xl border-border bg-secondary/40">
                            <option value="">همه دسته‌بندی‌ها</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->slug }}" @selected($selectedCategory === $category->slug)>
                                    {{ $category->name }} ({{ $category->posts_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="inline-flex items-center justify-center h-11 rounded-full bg-primary px-5 text-sm font-bold text-primary-foreground hover:opacity-80 transition-all">اعمال فیلتر</button>
                        <a href="{{ route('blog.index') }}" class="inline-flex items-center justify-center h-11 rounded-full bg-secondary px-5 text-sm font-bold text-foreground hover:text-primary transition-all">حذف فیلتر</a>
                    </div>
                </form>
            </aside>

            <section class="lg:col-span-9">
                @if ($posts->count())
                    <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach ($posts as $post)
                            <article class="rounded-3xl border border-border bg-background p-4 shadow-lg shadow-black/5 hover:shadow-xl transition-all">
                                <a href="{{ route('single.blog.show', $post->slug) }}" class="block overflow-hidden rounded-2xl">
                                    <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="h-52 w-full object-cover transition-transform duration-300 hover:scale-105">
                                </a>
                                <div class="space-y-4 pt-4">
                                    <div class="flex items-center justify-between gap-3 text-xs text-muted">
                                        <span>{{ verta($post->created_at)->format('Y/m/d') }}</span>
                                        @if ($post->post_categorie)
                                            <a href="{{ route('blog.index', ['category' => $post->post_categorie->slug]) }}" class="rounded-full bg-primary/10 px-3 py-1 font-bold text-primary hover:opacity-80">{{ $post->post_categorie->name }}</a>
                                        @endif
                                    </div>
                                    <h2 class="text-base font-black text-foreground leading-8 line-clamp-2">
                                        <a href="{{ route('single.blog.show', $post->slug) }}" class="hover:text-primary transition-colors">{{ $post->title }}</a>
                                    </h2>
                                    <p class="text-sm leading-7 text-muted line-clamp-3">{{ \Illuminate\Support\Str::limit(strip_tags($post->body), 120) }}</p>
                                    <div class="flex items-center gap-3 border-t border-border pt-4">
                                        <img src="{{ asset('storage/' . $post->user->avatar) }}" alt="{{ $post->user->name }}" class="h-10 w-10 rounded-full object-cover">
                                        <div>
                                            <div class="text-sm font-bold text-foreground">{{ $post->user->name }}</div>
                                            <div class="text-xs text-muted">نویسنده</div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="pt-8">
                        {{ $posts->links() }}
                    </div>
                @else
                    <div class="rounded-3xl border border-border bg-background p-10 text-center">
                        <h2 class="text-xl font-black text-foreground">مقاله‌ای پیدا نشد</h2>
                        <p class="mt-3 text-sm text-muted">فیلترها را تغییر بدهید یا جستجوی دیگری انجام دهید.</p>
                    </div>
                @endif
            </section>
        </section>
    </div>
</main>
@endsection
