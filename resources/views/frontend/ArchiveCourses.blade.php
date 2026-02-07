@extends('frontend.layouts.master')


@section('title', 'همه دوره ها')
@section('canonical', url()->current())


@section('content')

    <main class="flex-auto py-5" x-data="courseFilters()">
        <div class="max-w-7xl space-y-14 px-4 mx-auto">
            <div class="space-y-8">
                <!-- section:title -->
                <div class="flex items-center gap-5">
                    <span class="flex items-center justify-center w-12 h-12 bg-primary text-primary-foreground rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M9.664 1.319a.75.75 0 0 1 .672 0 41.059 41.059 0 0 1 8.198 5.424.75.75 0 0 1-.254 1.285 31.372 31.372 0 0 0-7.86 3.83.75.75 0 0 1-.84 0 31.508 31.508 0 0 0-2.08-1.287V9.394c0-.244.116-.463.302-.592a35.504 35.504 0 0 1 3.305-2.033.75.75 0 0 0-.714-1.319 37 37 0 0 0-3.446 2.12A2.216 2.216 0 0 0 6 9.393v.38a31.293 31.293 0 0 0-4.28-1.746.75.75 0 0 1-.254-1.285 41.059 41.059 0 0 1 8.198-5.424ZM6 11.459a29.848 29.848 0 0 0-2.455-1.158 41.029 41.029 0 0 0-.39 3.114.75.75 0 0 0 .419.74c.528.256 1.046.53 1.554.82-.21.324-.455.63-.739.914a.75.75 0 1 0 1.06 1.06c.37-.369.69-.77.96-1.193a26.61 26.61 0 0 1 3.095 2.348.75.75 0 0 0 .992 0 26.547 26.547 0 0 1 5.93-3.95.75.75 0 0 0 .42-.739 41.053 41.053 0 0 0-.39-3.114 29.925 29.925 0 0 0-5.199 2.801 2.25 2.25 0 0 1-2.514 0c-.41-.275-.826-.541-1.25-.797a6.985 6.985 0 0 1-1.084 3.45 26.503 26.503 0 0 0-1.281-.78A5.487 5.487 0 0 0 6 12v-.54Z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                    <div class="flex flex-col space-y-2">
                        <span class="font-black xs:text-2xl text-lg text-primary">دوره های آموزشی</span>
                        <span class="font-semibold text-xs text-muted">دوره ببین، تمرین کن، برنامه نویس شو</span>
                    </div>
                </div>
                <!-- end section:title -->

                <div class="grid md:grid-cols-12 grid-cols-1 items-start gap-5">
                    <div class="md:block hidden lg:col-span-3 md:col-span-4 md:sticky md:top-24">
                        <div class="w-full flex flex-col space-y-3 mb-3">
                            <span class="font-bold text-sm text-foreground">جستجو دوره</span>
                            <form action="#" @submit.prevent>
                                <div class="flex items-center relative">
                                    <input type="text" id="SearchCourse" x-model.debounce.500ms="search"
                                        class="form-input w-full !ring-0 !ring-offset-0 h-10 bg-secondary !border-0 rounded-xl text-sm text-foreground"
                                        placeholder="عنوان دوره..">
                                    <span class="absolute left-3 text-muted">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-5 h-5">
                                            <path fill-rule="evenodd"
                                                d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                </div>
                            </form>
                        </div>

                        <!-- status filters -->
                        <div class="w-full flex flex-col space-y-3 mb-3">
                            <div class="w-full h-11 flex items-center bg-secondary rounded-2xl px-3">
                                <label class="relative w-full flex items-center justify-between cursor-pointer">
                                    <span class="font-bold text-sm text-foreground">در حال برگزاری</span>
                                    <input type="checkbox" value="performing" x-model="status" class="sr-only peer" />
                                    <div
                                        class="w-11 h-5 relative bg-background border-2 border-border peer-focus:outline-none rounded-full peer peer-checked:after:left-[26px] peer-checked:after:bg-background after:content-[''] after:absolute after:left-0.5 after:top-0.5 after:bg-border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-primary peer-checked:border-primary">
                                    </div>
                                </label>
                            </div>
                            <div class="w-full h-11 flex items-center bg-secondary rounded-2xl px-3">
                                <label class="relative w-full flex items-center justify-between cursor-pointer">
                                    <span class="font-bold text-sm text-foreground">تکمیل شده</span>
                                    <input type="checkbox" value="completed" x-model="status" class="sr-only peer" />
                                    <div
                                        class="w-11 h-5 relative bg-background border-2 border-border peer-focus:outline-none rounded-full peer peer-checked:after:left-[26px] peer-checked:after:bg-background after:content-[''] after:absolute after:left-0.5 after:top-0.5 after:bg-border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-primary peer-checked:border-primary">
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- accordion:container -->
                        @include('frontend.partials.ArchiveCourses.accordion')

                        <!-- end accordion:container -->
                    </div>

                    <div class="lg:col-span-9 md:col-span-8">
                        <!-- sort & filter(offcanvas) -->
                        <div class="flex items-center gap-3 mb-3" x-data="{ offcanvasOpen: false }">
                            <!-- sort -->
                            <div>
                                <!-- form:select container -->
                                <div class="flex items-center gap-3">
                                    <!-- form:select:label -->
                                    <label class="sm:flex hidden items-center gap-1 font-semibold text-xs text-muted">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-5 h-5">
                                            <path
                                                d="M10 3.75a2 2 0 1 0-4 0 2 2 0 0 0 4 0ZM17.25 4.5a.75.75 0 0 0 0-1.5h-5.5a.75.75 0 0 0 0 1.5h5.5ZM5 3.75a.75.75 0 0 1-.75.75h-1.5a.75.75 0 0 1 0-1.5h1.5a.75.75 0 0 1 .75.75ZM4.25 17a.75.75 0 0 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5h1.5ZM17.25 17a.75.75 0 0 0 0-1.5h-5.5a.75.75 0 0 0 0 1.5h5.5ZM9 10a.75.75 0 0 1-.75.75h-5.5a.75.75 0 0 1 0-1.5h5.5A.75.75 0 0 1 9 10ZM17.25 10.75a.75.75 0 0 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5h1.5ZM14 10a2 2 0 1 0-4 0 2 2 0 0 0 4 0ZM10 16.25a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
                                        </svg>
                                        مرتب سازی:
                                    </label><!-- end form:select:label -->

                                    <!-- form:select -->
                                    <div class="w-52 relative">

                                        <!-- form:select:button -->
                                        <button x-on:click="sortOpen = !sortOpen"
                                            class="flex items-center w-full h-11 relative bg-secondary rounded-2xl font-semibold text-xs text-foreground px-4">
                                            <span class="line-clamp-1" x-text="selectedSortLabel"></span>
                                            <span class="absolute left-3 pointer-events-none transition-transform"
                                                x-bind:class="sortOpen ? 'rotate-180' : ''">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </span>
                                        </button><!-- end form:select:button -->

                                        <!-- form:select:options container -->
                                        <div class="absolute w-full bg-background rounded-2xl shadow-lg overflow-hidden mt-2 z-30"
                                            x-show="sortOpen" x-on:click.away="sortOpen = false">
                                            <ul class="max-h-48 overflow-y-auto">
                                                <template x-for="(opt, index) in sortOptions" :key="index">
                                                    <!-- form:select option -->
                                                    <li class="font-medium text-xs text-foreground cursor-pointer hover:bg-secondary px-4 py-3"
                                                        x-on:click="sort = opt.value; sortOpen = false"
                                                        x-text="opt.label"></li><!-- end form:select:option -->
                                                </template>
                                            </ul>
                                        </div><!-- end form:select:options container -->
                                    </div><!-- end form:select -->
                                </div><!-- end form:select container -->
                            </div>
                            <!-- end sort -->

                            <!-- filter:offcanvas:button -->
                            <button type="button"
                                class="md:hidden flex items-center gap-1 h-11 bg-secondary rounded-2xl text-foreground px-4"
                                x-on:click="offcanvasOpen = true">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                                </svg>
                                <span class="hidden sm:block font-semibold text-xs">فیلتر دوره ها</span>
                            </button>
                            <!-- end filter:offcanvas:button -->

                            <!-- filter:offcanvas -->
                            <div x-cloak>
                                <!-- offcanvas:box -->
                                <div class="fixed inset-y-0 right-0 xs:w-80 w-72 h-full bg-background rounded-l-2xl overflow-y-auto transition-transform z-50"
                                    x-bind:class="offcanvasOpen ? '!translate-x-0' : 'translate-x-full'">

                                    <!-- offcanvas:header -->
                                    <div
                                        class="flex items-center justify-between gap-x-4 sticky top-0 bg-background p-4 z-10">
                                        <div class="font-bold text-sm text-foreground">فیلتر دوره ها</div>

                                        <!-- offcanvas:close-button -->
                                        <button x-on:click="offcanvasOpen = false"
                                            class="text-black dark:text-white focus:outline-none hover:text-red-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                        <!-- end offcanvas:close-button -->
                                    </div>
                                    <!-- end offcanvas header -->

                                    <!-- offcanvas:content -->
                                    <div class="p-4">
                                        <div class="w-full flex flex-col space-y-3 mb-3">
                                            <span class="font-bold text-sm text-foreground">جستجو دوره</span>
                                            <form action="#" @submit.prevent>
                                                <div class="flex items-center relative">
                                                    <input type="text" x-model.debounce.500ms="search"
                                                        class="form-input w-full !ring-0 !ring-offset-0 h-10 bg-secondary !border-0 rounded-xl text-sm text-foreground"
                                                        placeholder="عنوان دوره..">
                                                    <span class="absolute left-3 text-muted">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-5 h-5">
                                                            <path fill-rule="evenodd"
                                                                d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="w-full h-11 flex items-center bg-secondary rounded-2xl px-3 mb-3">
                                            <label
                                                class="relative w-full flex items-center justify-between cursor-pointer">
                                                <span class="font-bold text-sm text-foreground">در حال
                                                    برگزاری</span>
                                                <input type="checkbox" value="performing" x-model="status" class="sr-only peer" />
                                                <div
                                                    class="w-11 h-5 relative bg-background border-2 border-border peer-focus:outline-none rounded-full peer peer-checked:after:left-[26px] peer-checked:after:bg-background after:content-[''] after:absolute after:left-0.5 after:top-0.5 after:bg-border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-primary peer-checked:border-primary">
                                                </div>
                                            </label>
                                        </div>

                                         <div class="w-full h-11 flex items-center bg-secondary rounded-2xl px-3 mb-3">
                                            <label
                                                class="relative w-full flex items-center justify-between cursor-pointer">
                                                <span class="font-bold text-sm text-foreground">تکمیل شده</span>
                                                <input type="checkbox" value="completed" x-model="status" class="sr-only peer" />
                                                <div
                                                    class="w-11 h-5 relative bg-background border-2 border-border peer-focus:outline-none rounded-full peer peer-checked:after:left-[26px] peer-checked:after:bg-background after:content-[''] after:absolute after:left-0.5 after:top-0.5 after:bg-border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-primary peer-checked:border-primary">
                                                </div>
                                            </label>
                                        </div>

                                        <!-- accordion:container -->
                                        @include('frontend.partials.ArchiveCourses.accordion')
                                    </div>
                                    <!-- end offcanvas:content -->
                                </div>
                                <!-- end offcanvas:box -->

                                <!-- offcanvas:overlay -->
                                <div class="fixed inset-0 bg-black/10 dark:bg-white/10 cursor-pointer transition-all duration-1000 z-40"
                                    x-bind:class="offcanvasOpen ? 'opacity-100 visible' : 'opacity-0 invisible'"
                                    x-on:click="offcanvasOpen = false"></div>
                                <!-- end offcanvas:overlay -->
                            </div>
                            <!-- end filter:offcanvas -->
                        </div>
                        <!-- end sort & filter(offcanvas) -->

                        <!-- courses:wrapper -->
                        <div id="result_ajax" class="grid lg:grid-cols-3 sm:grid-cols-2 gap-x-5 gap-y-10" :class="{ 'opacity-50': isLoading }" @click="handlePagination">
                            @include('frontend.partials.ArchiveCourses.course-list')
                        </div>
                        <!-- courses:wrapper -->

                    </div>
                </div>
            </div>
        </div>
    </main>


    <script>
        function courseFilters() {
            return {
                search: '',
                category: '',
                type: '', // free, cash, all
                status: [], // performing, completed
                sort: 'newest',
                sortOpen: false,
                sortOptions: [
                    { label: 'جدید‌ترین', value: 'newest' },
                    { label: 'قدیمی‌ترین', value: 'oldest' },
                    { label: 'ارزان‌ترین', value: 'price_asc' },
                    { label: 'گران‌ترین', value: 'price_desc' }
                ],
                isLoading: false,

                get selectedSortLabel() {
                    const option = this.sortOptions.find(o => o.value === this.sort);
                    return option ? option.label : 'جدید‌ترین';
                },

                init() {
                    // Initialize from URL params
                    const params = new URLSearchParams(window.location.search);
                    if(params.has('search')) this.search = params.get('search');
                    if(params.has('category')) this.category = params.get('category');
                    if(params.has('type')) this.type = params.get('type');
                    if(params.has('sort')) this.sort = params.get('sort');
                    // Handle array for status
                    if(params.has('status[]')) {
                         this.status = params.getAll('status[]');
                    }

                    this.$watch('search', () => { this.page = 1; this.fetchCourses(); });
                    this.$watch('category', () => { this.page = 1; this.fetchCourses(); });
                    this.$watch('type', () => { this.page = 1; this.fetchCourses(); });
                    this.$watch('status', () => { this.page = 1; this.fetchCourses(); });
                    this.$watch('sort', () => { this.page = 1; this.fetchCourses(); });

                    // Handle browser back/forward buttons
                    window.addEventListener('popstate', () => {
                        const params = new URLSearchParams(window.location.search);
                        this.search = params.get('search') || '';
                        this.category = params.get('category') || '';
                        this.type = params.get('type') || '';
                        this.sort = params.get('sort') || 'newest';
                        this.status = params.getAll('status[]') || [];
                        this.fetchCourses(window.location.href);
                    });
                },

                handlePagination(e) {
                    const link = e.target.closest('a.page-link') || e.target.closest('.pagination a');
                    if (link) {
                        e.preventDefault();
                        this.fetchCourses(link.href);
                        // Scroll to top of results
                        document.getElementById('result_ajax').scrollIntoView({ behavior: 'smooth' });
                    }
                },

                fetchCourses(url = null) {
                    this.isLoading = true;

                    let fetchUrl;

                    if (url) {
                        fetchUrl = url;
                        // Update browser URL to match the pagination link
                        window.history.pushState({}, '', url);
                    } else {
                        // Build URL from state
                        let params = new URLSearchParams();
                        if(this.search) params.append('search', this.search);
                        if(this.category && this.category !== 'all') params.append('category', this.category);
                        if(this.type && this.type !== 'all') params.append('type', this.type);
                        if(this.status.length > 0) {
                             this.status.forEach(s => params.append('status[]', s));
                        }
                        if(this.sort) params.append('sort', this.sort);

                        // Reset to page 1 if not paginating (already handled by watchers resetting page?)
                        // Actually, if we are filtering, we start from scratch (page 1 implied by absence of page param)

                        const queryString = params.toString();
                        fetchUrl = '{{ route("courses.show") }}' + (queryString ? '?' + queryString : '');

                        // Update browser URL
                        window.history.pushState({}, '', fetchUrl);
                    }

                    fetch(fetchUrl, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('result_ajax').innerHTML = html;
                        this.isLoading = false;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        this.isLoading = false;
                    });
                }
            }
        }
    </script>
@endsection
