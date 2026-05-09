@extends('frontend.layouts.master')

@section('title', 'آرش فدایی - توسعه‌دهنده ارشد وب و متخصص PHP')
@section('description', 'آرش فدایی توسعه دهنده فول استک و موسس سایت ملودی من یک سایت موزیک ایرانی با قابلیت های جذاب')
@section('canonical', url()->current())

@section('content')
    <main class="flex-auto py-5">



        <div class="space-y-14">
            <!-- container -->
            <div class="max-w-7xl space-y-14 px-4 mx-auto">
                <!-- intro -->
                @include('frontend.partials.Home.intro')

                <!-- end intro -->






                <!-- section:latest-courses -->
                @include('frontend.partials.Home.latest-courses', ['courses' => $courses])


                <!-- end section:latest-courses -->
            </div>
            <!-- end container -->


            {{-- جدید: سکشن آخرین نمونه کارها --}}
            {{-- جدید: سکشن آخرین نمونه کارها --}}
            <section class="max-w-7xl space-y-6 px-4 mx-auto text-center">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 inline-block border-b-2 border-blue-600 pb-2">
                    آخرین نمونه کارها
                </h2>
                <p class="text-gray-500">برخی از پروژه‌های اخیر من</p>

                {{-- دسکتاپ: گرید ۴ ستونه --}}
                <div class=" md:grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
                    {{-- آیتم ۱ --}}
                    <div
                        class="group bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="aspect-square w-full overflow-hidden">
                            <img src="{{ asset('frontend/portfilio/appleid.webp') }}" alt="پروژه اپل ایدی تاپ"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <div class="py-3 px-2 text-center">
                            <h3 class="font-semibold text-gray-800">سایت اپل ایدی تاپ</h3>
                        </div>
                    </div>
                    {{-- آیتم ۲ --}}
                    <div
                        class="group bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="aspect-square w-full overflow-hidden" style="
    height: 88%;
">
                            <img src="{{ asset('frontend/portfilio/ewig.jpeg') }}" style="height: 96%" alt="پروژه اویگ هوم"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <div class="py-3 px-2 text-center">
                            <h3 class="font-semibold text-gray-800">سایت اویگ هوم </h3>
                        </div>
                    </div>
                    {{-- آیتم ۳ --}}
                    <div
                        class="group bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="aspect-square w-full overflow-hidden">
                            <img src="{{ asset('frontend/portfilio/volnanusic.png') }}" alt="سایت ولناموزیک"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <div class="py-3 px-2 text-center">
                            <h3 class="font-semibold text-gray-800"> سایت ولناموزیک</h3>
                        </div>
                    </div>
                    {{-- آیتم ۴ --}}
                    <div
                        class="group bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="aspect-square w-full overflow-hidden">
                            <img src="{{ asset('frontend/portfilio/iranausbildung.png') }}" alt="سایت ایران آوسبیلدونگ"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <div class="py-3 px-2 text-center">
                            <h3 class="font-semibold text-gray-800">سایت ایران اوسبیلدونگ</h3>
                        </div>
                    </div>
                </div>

            </section>



            <!-- feedback -->
            @include('frontend.partials.Home.feedback')

            <!-- end feedback -->

            <!-- container -->
            <div class="max-w-7xl space-y-14 px-4 mx-auto rounded-lg">
                <!-- articles -->
                @include('frontend.partials.Home.articles', ['posts' => $posts])
                <!-- end articles -->
            </div>
            <!-- end container -->



        </div>
    </main>

    <script>
        (function() {
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initMobileSlider);
            } else {
                initMobileSlider();
            }

            function initMobileSlider() {
                const track = document.getElementById('sliderTrack');
                if (!track) return;
                const slides = track.children;
                const slideCount = slides.length;
                if (slideCount === 0) return;

                let currentIndex = 0;
                const prevBtn = document.getElementById('prevSlide');
                const nextBtn = document.getElementById('nextSlide');
                const dotsContainer = document.getElementById('dotsContainer');

                function updateSlider() {
                    const translateX = -currentIndex * 100;
                    track.style.transform = `translateX(${translateX}%)`;
                    if (dotsContainer) {
                        const dots = dotsContainer.querySelectorAll('.dot');
                        dots.forEach((dot, idx) => {
                            if (idx === currentIndex) {
                                dot.classList.remove('bg-gray-300', 'w-2');
                                dot.classList.add('bg-blue-600', 'w-4');
                            } else {
                                dot.classList.remove('bg-blue-600', 'w-4');
                                dot.classList.add('bg-gray-300', 'w-2');
                            }
                        });
                    }
                }

                function goNext() {
                    currentIndex = (currentIndex + 1) % slideCount;
                    updateSlider();
                }

                function goPrev() {
                    currentIndex = (currentIndex - 1 + slideCount) % slideCount;
                    updateSlider();
                }

                if (prevBtn) prevBtn.addEventListener('click', goPrev);
                if (nextBtn) nextBtn.addEventListener('click', goNext);

                if (dotsContainer) {
                    dotsContainer.innerHTML = '';
                    for (let i = 0; i < slideCount; i++) {
                        const dot = document.createElement('button');
                        dot.classList.add('dot', 'h-2', 'rounded-full', 'transition-all', 'duration-200', 'mx-0.5');
                        if (i === currentIndex) {
                            dot.classList.add('bg-blue-600', 'w-4');
                        } else {
                            dot.classList.add('bg-gray-300', 'w-2');
                        }
                        dot.addEventListener('click', () => {
                            currentIndex = i;
                            updateSlider();
                        });
                        dotsContainer.appendChild(dot);
                    }
                }

                let touchStartX = 0;
                track.addEventListener('touchstart', (e) => {
                    touchStartX = e.changedTouches[0].screenX;
                });
                track.addEventListener('touchend', (e) => {
                    const touchEndX = e.changedTouches[0].screenX;
                    const delta = touchEndX - touchStartX;
                    if (Math.abs(delta) > 50) {
                        if (delta > 0) goPrev();
                        else goNext();
                    }
                });

                if (slideCount > 0) updateSlider();
            }
        })();
    </script>
@endsection
