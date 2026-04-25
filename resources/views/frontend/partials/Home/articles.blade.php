{{-- Section: Blog --}}
<section class="py-16 lg:py-24 bg-background dark:bg-zinc-950 transition-colors duration-300">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">


        <div
            class="flex items-center justify-between gap-8 bg-gradient-to-l from-secondary to-background rounded-2xl p-5">
            <div class="flex items-center gap-5">
                <span class="flex items-center justify-center w-12 h-12 bg-primary text-primary-foreground rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd"
                            d="M9.664 1.319a.75.75 0 0 1 .672 0 41.059 41.059 0 0 1 8.198 5.424.75.75 0 0 1-.254 1.285 31.372 31.372 0 0 0-7.86 3.83.75.75 0 0 1-.84 0 31.508 31.508 0 0 0-2.08-1.287V9.394c0-.244.116-.463.302-.592a35.504 35.504 0 0 1 3.305-2.033.75.75 0 0 0-.714-1.319 37 37 0 0 0-3.446 2.12A2.216 2.216 0 0 0 6 9.393v.38a31.293 31.293 0 0 0-4.28-1.746.75.75 0 0 1-.254-1.285 41.059 41.059 0 0 1 8.198-5.424ZM6 11.459a29.848 29.848 0 0 0-2.455-1.158 41.029 41.029 0 0 0-.39 3.114.75.75 0 0 0 .419.74c.528.256 1.046.53 1.554.82-.21.324-.455.63-.739.914a.75.75 0 1 0 1.06 1.06c.37-.369.69-.77.96-1.193a26.61 26.61 0 0 1 3.095 2.348.75.75 0 0 0 .992 0 26.547 26.547 0 0 1 5.93-3.95.75.75 0 0 0 .42-.739 41.053 41.053 0 0 0-.39-3.114 29.925 29.925 0 0 0-5.199 2.801 2.25 2.25 0 0 1-2.514 0c-.41-.275-.826-.541-1.25-.797a6.985 6.985 0 0 1-1.084 3.45 26.503 26.503 0 0 0-1.281-.78A5.487 5.487 0 0 0 6 12v-.54Z"
                            clip-rule="evenodd"></path>
                    </svg>
                </span>
                <div class="flex flex-col font-black text-2xl space-y-2">
                    <span class="font-black xs:text-2xl text-lg text-primary">آخرین مقالات منتشر شده</span>
                    <span class="font-semibold xs:text-base text-sm text-foreground">تازه های دنیای تکنولوژی</span>
                </div>
            </div>
            <a href="{{ route('blog.index') }}"
                class="sm:w-auto w-11 h-11 inline-flex items-center justify-center gap-1 bg-secondary rounded-full text-foreground transition-colors hover:text-primary sm:px-4">
                <span class="font-semibold text-sm sm:block hidden">مشاهده همه</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd"
                        d="M14.78 14.78a.75.75 0 0 1-1.06 0L6.5 7.56v5.69a.75.75 0 0 1-1.5 0v-7.5A.75.75 0 0 1 5.75 5h7.5a.75.75 0 0 1 0 1.5H7.56l7.22 7.22a.75.75 0 0 1 0 1.06Z"
                        clip-rule="evenodd"></path>
                </svg>
            </a>
        </div>

        {{-- Posts Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 mt-7">
            @foreach ($posts as $post)
                <article
                    class="group flex flex-col h-full bg-background dark:bg-zinc-900 border border-secondary/10 dark:border-secondary/20 rounded-3xl overflow-hidden transition-all duration-500 hover:shadow-xl hover:shadow-accent/5 dark:hover:shadow-accent-dark/10 hover:-translate-y-1">

                    {{-- Image Container --}}
                    <div class="relative aspect-[16/9] overflow-hidden">
                        <a href="{{ route('single.blog.show', $post->slug) }}" class="block h-full w-full">
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                loading="lazy" />
                        </a>

                        {{-- Floating Category Badge --}}
                        <div class="absolute top-4 right-4 rtl:left-4 rtl:right-auto z-10">
                            <a href="{{ route('blog.index', ['category' => $post->post_categorie->slug]) }}"
                                class="px-3 py-1.5 text-xs font-bold bg-white/90 dark:bg-zinc-800/90 backdrop-blur-md text-primary dark:text-primary-dark rounded-lg shadow-sm border border-secondary/20 hover:bg-accent hover:text-white dark:hover:bg-accent-dark transition-colors duration-300">
                                {{ $post->post_categorie->name ?? 'عمومی' }}
                            </a>
                        </div>
                    </div>

                    {{-- Content Body --}}
                    <div class="flex flex-col flex-grow p-6 space-y-4">

                        {{-- Date & Meta Info --}}
                        <div class="flex items-center gap-3 text-xs font-medium text-muted dark:text-muted-dark">
                            <span class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-4 h-4">
                                    <path fill-rule="evenodd"
                                        d="M6.756 3.063a.75.75 0 0 1 .531.737V6.5h.938a.75.75 0 0 1 0 1.5H8.15v3.75h.938a.75.75 0 0 1 0 1.5H7.5a.75.75 0 0 1-.75-.75V6.5H5.812a.75.75 0 0 1 0-1.5h.938V3.8a.75.75 0 0 1 .531-.737 10.004 10.004 0 0 1 8.458 0ZM4.5 10a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 0 .75.75h8.5a.75.75 0 0 0 .75-.75v-3.5a.75.75 0 0 1 1.5 0v3.5A2.25 2.25 0 0 1 14.5 17h-8.5A2.25 2.25 0 0 1 4 14.25v-3.5A.75.75 0 0 1 4.5 10Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>{{ verta($post->created_at)->format('Y/m/d') }}</span>
                            </span>
                            <span class="w-1 h-1 rounded-full bg-secondary/30"></span>
                            <span class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-4 h-4">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>۵ دقیقه مطالعه</span>
                            </span>
                        </div>

                        {{-- Title --}}
                        <h3
                            class="font-bold text-lg leading-snug text-primary dark:text-primary-dark line-clamp-2 group-hover:text-accent dark:group-hover:text-accent-dark transition-colors duration-300 mb-5 mt-5">
                            <a href="{{ route('single.blog.show', $post->slug) }}">
                                {{ $post->title }}
                            </a>
                        </h3>

                        {{-- Footer: Author & CTA --}}
                        <div
                            class="mt-auto pt-4 flex items-center justify-between border-t border-secondary/10 dark:border-secondary/20">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full overflow-hidden border border-secondary/20">
                                    <img src="{{ asset('storage/' . $post->user->avatar) }}"
                                        class="w-full h-full object-cover" alt="{{ $post->user->name }}">
                                </div>
                                <span
                                    class="text-xs font-semibold text-secondary dark:text-secondary-dark truncate max-w-[100px]">{{ $post->user->name }}</span>
                            </div>

                            <a href="{{ route('single.blog.show', $post->slug) }}"
                                class="flex items-center justify-center w-9 h-9 rounded-full bg-secondary/10 dark:bg-secondary/20 text-accent dark:text-accent-dark hover:bg-accent hover:text-white dark:hover:bg-accent-dark dark:hover:text-primary-dark transition-all duration-300 rtl:rotate-180">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.04-1.08l5.5 5.25a.75.75 0 0 1 0 1.08l-5.5 5.25a.75.75 0 1 1-1.04-1.08l4.158-3.96H3.75A.75.75 0 0 1 3 10Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
