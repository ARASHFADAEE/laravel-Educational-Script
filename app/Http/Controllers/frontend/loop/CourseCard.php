                                <div class="relative">
                                    <div class="relative z-10">
                                        <a href="/courses/<?php echo $course->slug ?>" class="block">
                                            <img src="/storage/<?php echo $course->thumbnail ?>"
                                                class="max-w-full rounded-3xl" alt="<?php echo $course->title ?>" />
                                        </a>
                                        <div id="category-name"
                                            class="absolute left-3 top-3 h-11 inline-flex items-center justify-center gap-1 bg-black/20 rounded-full text-white transition-all hover:opacity-80 px-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="w-6 h-6">
                                                <path fill-rule="evenodd"
                                                    d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span
                                                class="font-semibold text-sm"><?php echo $course->course_categorie->name ?></span>
                                        </div>
                                    </div>
                                    <div class="bg-background rounded-b-3xl -mt-12 pt-12">
                                        <div
                                            class="bg-gradient-to-b from-background to-secondary rounded-b-3xl space-y-2 p-5 mx-5">
                                            <div class="flex items-center gap-2">
                                                <span class="block w-1 h-1 bg-success rounded-full"></span>
                                                <span class="font-bold text-xs text-success">تکمیل شده</span>
                                            </div>
                                            <h2 class="font-bold text-sm">
                                                <a href="<?php echo Route('course.show', $course->slug) ?>"
                                                    class="line-clamp-1 text-foreground transition-colors hover:text-primary">
                                                    <?php echo $course->title ?> </a>
                                            </h2>
                                        </div>
                                        <div class="space-y-3 p-5">
                                            <div class="flex flex-wrap items-center gap-3">
                                                <div class="flex items-center gap-1 text-muted">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" class="w-5 h-5">
                                                        <path
                                                            d="M7 3.5A1.5 1.5 0 0 1 8.5 2h3.879a1.5 1.5 0 0 1 1.06.44l3.122 3.12A1.5 1.5 0 0 1 17 6.622V12.5a1.5 1.5 0 0 1-1.5 1.5h-1v-3.379a3 3 0 0 0-.879-2.121L10.5 5.379A3 3 0 0 0 8.379 4.5H7v-1Z">
                                                        </path>
                                                        <path
                                                            d="M4.5 6A1.5 1.5 0 0 0 3 7.5v9A1.5 1.5 0 0 0 4.5 18h7a1.5 1.5 0 0 0 1.5-1.5v-5.879a1.5 1.5 0 0 0-.44-1.06L9.44 6.439A1.5 1.5 0 0 0 8.378 6H4.5Z">
                                                        </path>
                                                    </svg>
                                                    <span class="font-semibold text-xs"><?php echo $course->lessons_count ?>
                                                        درس</span>
                                                </div>
                                                <span class="block w-1 h-1 bg-muted-foreground rounded-full"></span>
                                                <div class="flex items-center gap-1 text-muted">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" class="w-5 h-5">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="font-semibold text-xs"><?php echo $course->time_course ?>
                                                        ساعت</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center justify-between gap-5">
                                                <div class="flex items-center gap-3">
                                                    <div class="flex-shrink-0 w-10 h-10 rounded-full overflow-hidden">
                                                        <img src="/strage/<?php echo $course->user->avatar ?>"
                                                            class="w-full h-full object-cover" alt="..." />
                                                    </div>
                                                    <div class="flex flex-col items-start space-y-1">
                                                        <span class="line-clamp-1 font-semibold text-xs text-muted">مدرس
                                                            دوره:</span>
                                                        <div
                                                            class="line-clamp-1 font-bold text-xs text-foreground hover:text-primary">
                                                            <?php echo $course->user->name ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($course->sale_price)
                                                <div class="flex flex-col items-end justify-center h-14">
                                                    <span
                                                        class="line-through text-muted"><?php echo number_format($course->regular_price) ?></span>
                                                    <div class="flex items-center gap-1">
                                                        <span
                                                            class="font-black text-xl text-foreground"><?php echo number_format($course->sale_price) ?></span>
                                                        <span class="text-xs text-muted">تومان</span>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>