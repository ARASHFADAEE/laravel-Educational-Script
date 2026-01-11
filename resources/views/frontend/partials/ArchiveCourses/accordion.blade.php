                            <div class="flex flex-col divide-y divide-border">
                                <!-- accordion -->
                                <div class="w-full space-y-2 py-3" x-data="{ open: true }">
                                    <!-- accordion:button -->
                                    <button type="button"
                                        class="w-full h-11 flex items-center justify-between gap-x-2 relative bg-secondary rounded-2xl transition hover:text-primary px-3"
                                        x-bind:class="open ? 'text-primary' : 'text-foreground'"
                                        x-on:click="open = !open">
                                        <span class="flex items-center gap-x-2">
                                            <span class="flex-shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                                </svg>
                                            </span>
                                            <span class="font-semibold text-sm text-right">نوع دوره</span>
                                        </span>
                                        <span class="" x-bind:class="open ? 'rotate-180' : ''">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </span>
                                    </button><!-- end accordion:button -->

                                    <!-- accordion:content -->
                                    <div class="bg-secondary rounded-2xl relative p-3" x-show="open">
                                        <div class="space-y-2">
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="type"
                                                    class="form-radio !ring-0 !ring-offset-0 bg-border border-0" />
                                                <span class="text-sm text-muted">رایگان</span>
                                                <span class="text-sm text-muted mr-auto">۱۸</span>
                                            </label>
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="type"
                                                    class="form-radio !ring-0 !ring-offset-0 bg-border border-0" />
                                                <span class="text-sm text-muted">فقط نقدی</span>
                                                <span class="text-sm text-muted mr-auto">۹</span>
                                            </label>
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="radio" name="type"
                                                    class="form-radio !ring-0 !ring-offset-0 bg-border border-0" />
                                                <span class="text-sm text-muted">نقدی و اعضای ویژه</span>
                                                <span class="text-sm text-muted mr-auto">۴۳</span>
                                            </label>
                                        </div>
                                    </div><!-- end accordion:content -->
                                </div><!-- accordion -->

                                <!-- accordion -->
                                <div class="w-full space-y-2 py-3" x-data="{ open: false }">
                                    <!-- accordion:button -->
                                    <button type="button"
                                        class="w-full h-11 flex items-center justify-between gap-x-2 relative bg-secondary rounded-2xl transition hover:text-primary px-3"
                                        x-bind:class="open ? 'text-primary' : 'text-foreground'"
                                        x-on:click="open = !open">
                                        <span class="flex items-center gap-x-2">
                                            <span class="flex-shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                                                </svg>
                                            </span>
                                            <span class="font-semibold text-sm text-right">دسته بندی دوره</span>
                                        </span>
                                        <span class="" x-bind:class="open ? 'rotate-180' : ''">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </span>
                                    </button><!-- end accordion:button -->

                                    <!-- accordion:content -->
                                    <div class="bg-secondary rounded-2xl relative p-3" x-show="open">
                                        <div class="space-y-2">

                                            <form id="form-category-filter" name="form-category" action="{{Route('category.ajax')}}">
                                            @foreach ($categories as $category)

                                                <label class="flex items-center gap-2 cursor-pointer">
                                                    <input value="{{$category->slug}}" id="cat-name" type="radio"  name="category"
                                                        class="form-radio !ring-0 !ring-offset-0 bg-border border-0" />
                                                    <span class="text-sm text-muted">{{$category->name}}</span>
                                                </label>
                                                @endforeach

                                                </form>

                                        </div>
                                    </div><!-- end accordion:content -->
                                </div><!-- accordion -->
                            </div>
