@extends('frontend.layouts.master')

@section('title', $post->seo->meta_title ?? $post->title)
@section('description', $post->seo->meta_description ?? \Illuminate\Support\Str::limit(strip_tags($post->body), 160))
@section('canonical', route('single.blog.show', $post->slug))
@section('content')


@section('type', 'article')
@section('og-title', $post->seo->og_title ?? $post->title)
@section('og-description', $post->seo->og_description ?? $post->seo->meta_description ?? \Illuminate\Support\Str::limit(strip_tags($post->body), 160))
@section('og-img', $post->seo->og_image ? asset('storage/' . $post->seo->og_image) : asset('storage/' . $post->thumbnail))

@section('twitter-title', $post->seo->twitter_title ?? $post->title)
@section('twitter-description', $post->seo->twitter_description ?? $post->seo->meta_description ?? \Illuminate\Support\Str::limit(strip_tags($post->body), 160))
@section('twitter-img', $post->seo->og_image ? asset('storage/' . $post->seo->og_image) : asset('storage/' . $post->thumbnail))


@section('og:type', 'article')
@section('article:published_time', $post->created_at->toIso8601String())
@section('article:modified_time', $post->updated_at->toIso8601String())
@section('article:author', $post->user->name)
@section('twitter:label1', 'نوشته شده توسط')
@section('twitter:data1', $post->user->name)
@section('twitter:label2', 'زمان مطالعه')
@section('twitter:data2', ceil(str_word_count(strip_tags($post->body)) / 200) . ' دقیقه')

    <main class="flex-auto py-5">


            <!-- container -->
            <div class="max-w-7xl space-y-14 px-4 mx-auto">
                <div class="flex md:flex-nowrap flex-wrap items-start gap-5">
                    <div class="md:w-8/12 w-full">
                        <div class="relative">
                            <!-- article:thumbnail -->
                            <div class="relative z-10">
                                <img src="{{ asset('storage/') }}/{{ $post->thumbnail }}" class="max-w-full rounded-3xl"
                                    alt="..." />
                            </div>

                            <div class="-mt-12 pt-12">
                                <div class="bg-gradient-to-b from-background to-secondary rounded-b-3xl space-y-2 p-5 mx-5">
                                    <!-- article:title -->
                                    <h1 class="font-bold text-xl text-foreground">{{ $post->title }}</h1>

                                    {{-- <!-- article:excerpt -->
                                    <p class="text-sm text-muted">


                                    </p> --}}
                                </div>
                                <div class="space-y-10 py-5">
                                    <!-- article:description -->
                                    <div class="description article-content">

                                        {!! $post->body !!}
                                    </div>
                                    <!-- end article:description -->

                                    <!-- article:comments:container -->
                                    @include('frontend.partials.single-blog.comments')

                                    <!-- end article:comments:container -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="md:w-4/12 w-full md:sticky md:top-24 space-y-8">
                        <div class="space-y-5">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center gap-1">
                                    <div class="w-1 h-1 bg-foreground rounded-full"></div>
                                    <div class="w-2 h-2 bg-foreground rounded-full"></div>
                                </div>
                                <div class="font-black text-sm text-foreground">نویسنده:</div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full overflow-hidden">
                                        <img src="{{ asset('storage') }}/{{ $post->user->avatar }}"
                                            class="w-full h-full object-cover" alt="{{ $post->user->name }}" />
                                    </div>
                                    <div class="flex flex-col items-start space-y-1">
                                        <a href="./lecturer.html"
                                            class="line-clamp-1 font-bold text-sm text-foreground hover:text-primary">{{ $post->user->name }}
                                        </a>

                                    </div>
                                </div>
                                <div class="bg-secondary rounded-tl-3xl rounded-b-3xl text-sm text-muted p-5">

                                    {{ $post->user->bio }}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end container -->

    </main>


@endsection



@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BlogPosting",
    "headline": "{{ addslashes($post->title) }}",
    "name": "{{ addslashes($post->title) }}",
    "description": "{{ addslashes(strip_tags(substr($post->body, 0, 200))) }}",
    "url": "{{ route('single.blog.show', $post->slug) }}",
    "datePublished": "{{ $post->created_at->toIso8601String() }}",
    "dateModified": "{{ $post->updated_at->toIso8601String() }}",
    "dateCreated": "{{ $post->created_at->toIso8601String() }}",
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ route('single.blog.show', $post->slug) }}"
    },
    "author": {
        "@type": "Person",
        "name": "{{ addslashes($post->user->name) }}",
        "url": "{{ route('author.show', $post->user->id) }}"
    },
    "publisher": {
        "@type": "Organization",
        "name": "{{ env('APP_NAME') }}",
        "logo": {
            "@type": "ImageObject",
            "url": "{{ asset('images/logo.png') }}",
            "width": "200",
            "height": "50"
        }
    },
    "image": {
        "@type": "ImageObject",
        "url": "{{ asset('storage/' . $post->thumbnail) }}",
        "width": "1200",
        "height": "630"
    },
    "articleSection": "{{ optional($post->category)->name ?? 'عمومی' }}",
    "keywords": "{{ implode(', ', array_slice(explode(' ', strip_tags($post->title)), 0, 5)) }}",
    "articleBody": "{{ addslashes(strip_tags(substr($post->body, 0, 1000))) }}",
    "wordCount": {{ str_word_count(strip_tags($post->body)) }},
    "timeRequired": "PT{{ ceil(str_word_count(strip_tags($post->body)) / 200) }}M",
    "inLanguage": "fa-IR",
    "isAccessibleForFree": "True",
    "copyrightYear": "{{ $post->created_at->format('Y') }}",
    "copyrightHolder": {
        "@type": "Organization",
        "name": "{{ env('APP_NAME') }}"
    }
}
</script>
@endsection