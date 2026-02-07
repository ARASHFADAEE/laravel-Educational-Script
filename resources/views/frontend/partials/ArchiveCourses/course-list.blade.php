@foreach ($courses as $course)
    <!-- course:card -->
    <div class="relative">
        <div class="relative z-10">
            <a href="{{ Route('course.show', $course->slug) }}" class="block">
                <img src="{{ asset('storage') }}/{{ $course->thumbnail }}" class="max-w-full rounded-3xl"
                    alt="{{ $course->title }}" />
            </a>
            <div id="category-name"
                class="absolute left-3 top-3 h-11 inline-flex items-center justify-center gap-1 bg-black/20 rounded-full text-white transition-all hover:opacity-80 px-4">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path fill-rule="evenodd"
                        d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z"
                        clip-rule="evenodd" />
                </svg>
                <span class="font-semibold text-sm">{{ $course->course_categorie->name ?? 'بدون دسته‌بندی' }}</span>
            </div>
        </div>
        <div class="bg-background rounded-b-3xl -mt-12 pt-12">
            <div class="bg-gradient-to-b from-background to-secondary rounded-b-3xl space-y-2 p-5 mx-5">
                <div class="flex items-center gap-2">
                    <span class="block w-1 h-1 bg-success rounded-full"></span>
                    <span class="font-bold text-xs text-success">
                        @if ($course->status == 'completed')
                            تکمیل شده
                        @elseif($course->status == 'performing')
                            در حال برگزاری
                        @else
                            {{ $course->status }}
                        @endif
                    </span>
                </div>
                <h2 class="font-bold text-sm">
                    <a href="{{ Route('course.show', $course->slug) }}"
                        class="line-clamp-1 text-foreground transition-colors hover:text-primary">
                        {{ $course->title }} </a>
                </h2>
            </div>
            <div class="space-y-3 p-5">
                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex items-center gap-1 text-muted">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="w-5 h-5">
                            <path
                                d="M7 3.5A1.5 1.5 0 0 1 8.5 2h3.879a1.5 1.5 0 0 1 1.06.44l3.122 3.12A1.5 1.5 0 0 1 17 6.622V12.5a1.5 1.5 0 0 1-1.5 1.5h-1v-3.379a3 3 0 0 0-.879-2.121L10.5 5.379A3 3 0 0 0 8.379 4.5H7v-1Z">
                            </path>
                            <path
                                d="M4.5 6A1.5 1.5 0 0 0 3 7.5v9A1.5 1.5 0 0 0 4.5 18h7a1.5 1.5 0 0 0 1.5-1.5v-5.879a1.5 1.5 0 0 0-.44-1.06L9.44 6.439A1.5 1.5 0 0 0 8.378 6H4.5Z">
                            </path>
                        </svg>
                        <span class="font-semibold text-xs">{{ $course->chapters_count ?? 0 }}
                            فصل</span>
                    </div>
                    <span class="block w-1 h-1 bg-muted-foreground rounded-full"></span>
                    <div class="flex items-center gap-1 text-muted">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-semibold text-xs">{{ $course->time_course ?? '00:00' }}
                            ساعت</span>
                    </div>
                </div>
                <div class="flex items-center justify-between gap-5">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full overflow-hidden">
                            <img src="{{ asset('storage') }}/{{ $course->user->avatar ?? 'default-avatar.png' }}"
                                class="w-full h-full object-cover" alt="..." />
                        </div>
                        <div class="flex flex-col items-start space-y-1">
                            <span class="line-clamp-1 font-semibold text-xs text-muted">مدرس
                                دوره:</span>
                            <span class="line-clamp-1 font-bold text-xs text-foreground hover:text-primary">
                                {{ $course->user->name ?? 'ناشناس' }}
                            </span>
                        </div>
                    </div>
                    @if ($course->sale_price)
                        <div class="flex flex-col items-end justify-center h-14">
                            <span class="line-through text-muted">{{ number_format($course->regular_price) }}</span>
                            <div class="flex items-center gap-1">
                                <span
                                    class="font-black text-xl text-foreground">{{ number_format($course->sale_price) }}</span>
                                <span class="text-xs text-muted">تومان</span>
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col items-end justify-center h-14">
                            <div class="flex items-center gap-1">
                                <span class="font-black text-xl text-success">رایگان</span>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
    <!-- end course:card -->
@endforeach

<div class="col-span-full flex justify-center mt-8">
    {{ $courses->links() }}
</div>
