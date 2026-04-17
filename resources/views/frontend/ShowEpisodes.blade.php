@extends('frontend.layouts.master')

@section('title', 'مشاهده دوره | ' . $lesson->title)

@section('content')
<main class="bg-secondary/30 min-h-screen pb-12">
    <!-- Top Header / Breadcrumb -->
    <div class="bg-background border-b border-border">
        <div class="max-w-[1600px] mx-auto px-4 h-16 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ Route('course.show', $course->slug) }}" class="flex items-center justify-center w-10 h-10 rounded-xl bg-secondary text-muted hover:text-primary transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div class="hidden sm:block">
                    <h1 class="text-sm font-bold text-foreground line-clamp-1">{{ $lesson->title }}</h1>
                    <p class="text-[10px] text-muted">{{ $course->name }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <!-- Progress can be added here -->
                <div class="hidden md:flex items-center gap-2 px-4 py-2 bg-secondary rounded-xl">
                    <span class="text-xs font-bold text-primary">۴۰٪ تکمیل شده</span>
                    <div class="w-24 h-1.5 bg-background rounded-full overflow-hidden">
                        <div class="bg-primary h-full w-[40%]"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Player Section -->
    <div class="max-w-[1600px] mx-auto px-4 py-6">
        <div class="flex flex-col lg:flex-row gap-6">
            
            <!-- Left: Player & Content -->
            <div class="flex-1 space-y-6">
                <!-- Video Container -->
                <div class="relative bg-black rounded-3xl overflow-hidden shadow-2xl group border border-white/5">
                    <video class="js-player aspect-video" playsinline controls data-poster="{{asset('storage')}}/{{$course->thumbnail}}">
                        <source src="{{ $lesson->video_url }}" type="video/mp4" />
                    </video>
                </div>

                <!-- Lesson Info & Tabs -->
                <div class="bg-background rounded-3xl border border-border overflow-hidden" x-data="{ tab: 'description' }">
                    <div class="flex items-center border-b border-border px-6 overflow-x-auto no-scrollbar">
                        <button @click="tab = 'description'" :class="tab === 'description' ? 'text-primary border-primary' : 'text-muted border-transparent'" class="px-6 py-4 text-sm font-bold border-b-2 transition-all whitespace-nowrap">توضیحات جلسه</button>
                        <button @click="tab = 'comments'" :class="tab === 'comments' ? 'text-primary border-primary' : 'text-muted border-transparent'" class="px-6 py-4 text-sm font-bold border-b-2 transition-all whitespace-nowrap">پرسش و پاسخ</button>
                        <button @click="tab = 'files'" :class="tab === 'files' ? 'text-primary border-primary' : 'text-muted border-transparent'" class="px-6 py-4 text-sm font-bold border-b-2 transition-all whitespace-nowrap">فایل‌های ضمیمه</button>
                    </div>

                    <div class="p-6 sm:p-8">
                        <div x-show="tab === 'description'" class="animate-in fade-in duration-300">
                            <h2 class="text-xl font-black text-foreground mb-4">{{ $lesson->title }}</h2>
                            <div class="prose prose-sm max-w-none text-muted leading-relaxed">
                                {!! $lesson->description ?? 'توضیحاتی برای این جلسه ثبت نشده است.' !!}
                            </div>
                        </div>

                        <div x-show="tab === 'comments'" class="animate-in fade-in duration-300">
                            <!-- Comment Component can go here -->
                            <p class="text-center py-8 text-muted text-sm italic">بخش نظرات به زودی فعال می‌شود.</p>
                        </div>

                        <div x-show="tab === 'files'" class="animate-in fade-in duration-300">
                            <div class="grid sm:grid-cols-2 gap-4">
                                <div class="flex items-center justify-between p-4 bg-secondary rounded-2xl border border-border group hover:border-primary/30 transition-all">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-foreground line-clamp-1">سورس کد جلسه</p>
                                            <p class="text-[10px] text-muted">ZIP - 1.2 MB</p>
                                        </div>
                                    </div>
                                    <button class="text-xs font-bold text-primary group-hover:underline">دانلود</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Playlist Sidebar -->
            <div class="w-full lg:w-96 space-y-4">
                <div class="bg-background rounded-3xl border border-border flex flex-col h-[600px] lg:sticky lg:top-6">
                    <div class="p-5 border-b border-border flex items-center justify-between">
                        <h3 class="font-black text-foreground flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                            سرفصل‌های دوره
                        </h3>
                        <span class="text-[10px] bg-secondary px-2 py-1 rounded-lg text-muted">{{ count($chapters) }} فصل</span>
                    </div>

                    <div class="flex-1 overflow-y-auto p-2 space-y-2 custom-scrollbar">
                        @foreach($chapters as $chapter)
                        @php
                            $isActiveChapter = $chapter->lessons->contains('slug', request()->slug);
                        @endphp
                        <div x-data="{ open: {{ $isActiveChapter ? 'true' : 'false' }} }" class="space-y-1">
                            <button @click="open = !open" 
                                    class="w-full flex items-center justify-between p-3 rounded-2xl transition-all"
                                    :class="open ? 'bg-primary/5 text-primary' : 'hover:bg-secondary text-foreground'">
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-lg flex items-center justify-center text-xs font-bold" :class="open ? 'bg-primary text-white' : 'bg-secondary text-muted'">
                                        {{ $loop->iteration }}
                                    </span>
                                    <span class="text-xs font-black text-right line-clamp-1">{{ $chapter->title }}</span>
                                </div>
                                <svg class="w-4 h-4 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="open" x-cloak class="space-y-1 pr-2 animate-in slide-in-from-top-2 duration-300">
                                @foreach($chapter->lessons as $item)
                                @php $isCurrent = request()->slug == $item->slug; @endphp
                                <a href="{{ route('lesson.show', $item->slug) }}" 
                                   class="group flex items-center gap-3 p-3 rounded-2xl transition-all {{ $isCurrent ? 'bg-primary shadow-lg shadow-primary/20' : 'hover:bg-secondary' }}">
                                    
                                    <div class="relative flex-shrink-0">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $isCurrent ? 'bg-white/20 text-white' : 'bg-secondary text-muted group-hover:bg-primary/10 group-hover:text-primary' }}">
                                            @if($isCurrent)
                                                <svg class="w-4 h-4 animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z"/>
                                                </svg>
                                            @else
                                                <span class="text-[10px] font-bold">{{ $loop->iteration }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <p class="text-[11px] font-bold truncate {{ $isCurrent ? 'text-white' : 'text-foreground group-hover:text-primary' }}">
                                            {{ $item->title }}
                                        </p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-[9px] {{ $isCurrent ? 'text-white/70' : 'text-muted' }} flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                {{ $item->duration ?? '۰۳:۵۸' }}
                                            </span>
                                        </div>
                                    </div>

                                    @if($isCurrent)
                                        <div class="w-1.5 h-1.5 rounded-full bg-white shadow-sm"></div>
                                    @endif
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; }
    
    [x-cloak] { display: none !important; }
</style>
@endsection
