@extends('user.dashboard')


@section('title', 'پروفایل من')



@section('content-dashboard')


    <div class="lg:col-span-9 md:col-span-8">
        <div class="space-y-10">
            <div class="space-y-5">
                <!-- section:title -->
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-1">
                        <div class="w-1 h-1 bg-foreground rounded-full"></div>
                        <div class="w-2 h-2 bg-foreground rounded-full"></div>
                    </div>
                    <div class="font-black text-foreground">ویرایش پروفایل</div>
                </div>
                <!-- end section:title -->

                <!-- tabs container -->
                <div class="space-y-5" x-data="{ activeTab: 'tabOne' }">
                    <!-- tabs:list-container -->
                    <div class="relative overflow-x-auto">
                        <!-- tabs:list -->
                        <ul class="inline-flex gap-2 bg-secondary border border-border rounded-full p-1">
                            <!-- tabs:list:item -->
                            <li>
                                <button type="button"
                                    class="flex items-center gap-x-2 w-full relative rounded-full py-2 px-4"
                                    x-bind:class="activeTab === 'tabOne' ? 'text-foreground bg-background' : 'text-muted'"
                                    x-on:click="activeTab = 'tabOne'">
                                    <!-- active icon -->
                                    <span x-show="activeTab === 'tabOne'">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="w-5 h-5">
                                            <path
                                                d="M16.7574 2.99677L9.29145 10.4627L9.29886 14.7098L13.537 14.7024L21 7.23941V19.9968C21 20.5491 20.5523 20.9968 20 20.9968H4C3.44772 20.9968 3 20.5491 3 19.9968V3.99677C3 3.44448 3.44772 2.99677 4 2.99677H16.7574ZM20.4853 2.09727L21.8995 3.51149L12.7071 12.7039L11.2954 12.7063L11.2929 11.2897L20.4853 2.09727Z">
                                            </path>
                                        </svg>
                                    </span><!-- end active icon -->

                                    <!-- inactive icon -->
                                    <span x-show="activeTab !== 'tabOne'">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="w-5 h-5">
                                            <path
                                                d="M16.7574 2.99677L14.7574 4.99677H5V18.9968H19V9.23941L21 7.23941V19.9968C21 20.5491 20.5523 20.9968 20 20.9968H4C3.44772 20.9968 3 20.5491 3 19.9968V3.99677C3 3.44448 3.44772 2.99677 4 2.99677H16.7574ZM20.4853 2.09727L21.8995 3.51149L12.7071 12.7039L11.2954 12.7063L11.2929 11.2897L20.4853 2.09727Z">
                                            </path>
                                        </svg>
                                    </span><!-- end inactive icon -->

                                    <span class="font-semibold text-sm whitespace-nowrap">اطلاعات
                                        حساب</span>
                                </button>
                            </li><!-- end tabs:list:item -->

                            <!-- tabs:list:item -->
                            <li>
                                <button type="button"
                                    class="flex items-center gap-x-2 w-full relative rounded-full py-2 px-4"
                                    x-bind:class="activeTab === 'tabTwo' ? 'text-foreground bg-background' : 'text-muted'"
                                    x-on:click="activeTab = 'tabTwo'">
                                    <!-- active icon -->
                                    <span x-show="activeTab === 'tabTwo'">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="w-5 h-5">
                                            <path
                                                d="M6 2H18C18.5523 2 19 2.44772 19 3V21C19 21.5523 18.5523 22 18 22H6C5.44772 22 5 21.5523 5 21V3C5 2.44772 5.44772 2 6 2ZM12 17C11.4477 17 11 17.4477 11 18C11 18.5523 11.4477 19 12 19C12.5523 19 13 18.5523 13 18C13 17.4477 12.5523 17 12 17Z">
                                            </path>
                                        </svg>
                                    </span><!-- end active icon -->

                                    <!-- inactive icon -->
                                    <span x-show="activeTab !== 'tabTwo'">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="w-5 h-5">
                                            <path
                                                d="M7 4V20H17V4H7ZM6 2H18C18.5523 2 19 2.44772 19 3V21C19 21.5523 18.5523 22 18 22H6C5.44772 22 5 21.5523 5 21V3C5 2.44772 5.44772 2 6 2ZM12 17C12.5523 17 13 17.4477 13 18C13 18.5523 12.5523 19 12 19C11.4477 19 11 18.5523 11 18C11 17.4477 11.4477 17 12 17Z">
                                            </path>
                                        </svg>
                                    </span><!-- end inactive icon -->

                                    <span class="font-semibold text-sm whitespace-nowrap">رمز
                                        عبور</span>
                                </button>
                            </li><!-- end tabs:list:item -->

                            <!-- tabs:list:item -->


                        </ul><!-- end tabs:list -->
                    </div><!-- end tabs:list-container -->
                    <!-- tabs:contents -->
                    <div class="bg-background rounded-3xl p-5">
                        <!-- tabs:contents:tabOne -->
                        <div class="space-y-5" x-show="activeTab === 'tabOne'">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center gap-1">
                                    <div class="w-1 h-1 bg-foreground rounded-full"></div>
                                    <div class="w-2 h-2 bg-foreground rounded-full"></div>
                                </div>
                                <div class="font-black text-foreground">اطلاعات حساب</div>
                            </div>

                            <!-- فرم اطلاعات حساب -->
                            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data"
                                class="space-y-5">
                                @csrf
                                @method('PUT')

                                <div class="grid sm:grid-cols-2 gap-5">
                                    <div class="space-y-1">
                                        <label for="name" class="font-medium text-xs text-muted">نام و نام خانوادگی
                                            (فارسی)</label>
                                        <input type="text" id="name" name="name"
                                            value="{{ old('name', $user->name) }}"
                                            class="form-input w-full h-11 !ring-0 !ring-offset-0 bg-secondary border-border focus:border-border rounded-xl text-sm text-foreground px-5" />
                                        @error('name')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="space-y-1">
                                        <label for="email" class="font-medium text-xs text-muted">ایمیل</label>
                                        <input type="text" id="email" value="{{ $user->email }}" disabled
                                            dir="ltr"
                                            class="form-input w-full h-11 !ring-0 !ring-offset-0 bg-secondary border-border focus:border-border rounded-xl text-sm text-foreground px-5 opacity-70 cursor-not-allowed" />
                                        <div class="font-medium text-xs text-muted">
                                            در حال حاضر ایمیل قابل تغییر نمیباشد.
                                        </div>
                                    </div>

                                    <div class="space-y-1">
                                        <label for="phone" class="font-medium text-xs text-muted">شماره موبایل</label>
                                        <input type="text" id="phone" name="phone"
                                            value="{{ old('phone', $user->phone) }}" dir="ltr"
                                            class="form-input w-full h-11 !ring-0 !ring-offset-0 bg-secondary border-border focus:border-border rounded-xl text-sm text-foreground px-5" />
                                        @error('phone')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="space-y-1">
                                        <label for="avatar" class="font-medium text-xs text-muted">تصویر پروفایل</label>
                                        <input type="file" id="avatar" name="avatar" accept="image/*"
                                            class="form-input w-full h-11 !ring-0 !ring-offset-0 bg-secondary border-border focus:border-border rounded-xl text-sm text-foreground px-5 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/90" />
                                        @error('avatar')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror

                                        @if ($user->avatar)
                                            <div class="mt-2 flex items-center gap-2">
                                                <img src="{{ Storage::url($user->avatar) }}" alt="آواتار"
                                                    class="w-12 h-12 rounded-full object-cover">
                                                <button type="button" onclick="deleteAvatar()"
                                                    class="text-red-500 text-xs hover:text-red-700">
                                                    حذف تصویر
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex justify-end gap-5">
                                    <button type="submit"
                                        class="h-11 inline-flex items-center justify-center gap-3 bg-primary rounded-full text-white px-4 mr-auto">
                                        <span class="font-semibold text-sm">بروزرسانی</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-5 h-5">
                                            <path fill-rule="evenodd"
                                                d="M15.312 11.424a5.5 5.5 0 0 1-9.201 2.466l-.312-.311h2.433a.75.75 0 0 0 0-1.5H3.989a.75.75 0 0 0-.75.75v4.242a.75.75 0 0 0 1.5 0v-2.43l.31.31a7 7 0 0 0 11.712-3.138.75.75 0 0 0-1.449-.39Zm1.23-3.723a.75.75 0 0 0 .219-.53V2.929a.75.75 0 0 0-1.5 0V5.36l-.31-.31A7 7 0 0 0 3.239 8.188a.75.75 0 1 0 1.448.389A5.5 5.5 0 0 1 13.89 6.11l.311.31h-2.432a.75.75 0 0 0 0 1.5h4.243a.75.75 0 0 0 .53-.219Z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div><!-- end tabs:contents:tabOne -->


                        <!-- tabs:contents:tabTwo -->
                        <div class="space-y-5" x-show="activeTab === 'tabTwo'">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center gap-1">
                                    <div class="w-1 h-1 bg-foreground rounded-full"></div>
                                    <div class="w-2 h-2 bg-foreground rounded-full"></div>
                                </div>
                                <div class="font-black text-foreground">رمز عبور</div>
                            </div>
                            <!-- alert -->
                            <div class="flex items-start gap-3 relative bg-zinc-50 dark:bg-zinc-900 border border-border rounded-xl p-5"
                                x-show="open" x-data="{ open: true }">
                                <!-- alert:icon -->
                                <span class="text-yellow-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </span><!-- alert:icon -->

                                <!-- alert:content -->
                                <div class="flex flex-col items-start">
                                    <!-- alert:title -->
                                    <div class="font-bold text-sm text-yellow-500 mb-2">
                                        توجه :‌
                                    </div><!-- end alert:title -->

                                    <!-- alert:desc -->
                                    <div class="font-semibold text-xs text-zinc-400">
                                        <ul>
                                            <li>حداقل یک حرف کوچک استفاده کنید</li>
                                            <li>حداقل یک حرف بزرگ استفاده کنید</li>
                                            <li>پسورد حداقل باید ۸ کاراکتر باشد</li>
                                            <li>حداقل از یک عدد استفاده کنید</li>
                                        </ul>
                                    </div><!-- end alert:desc -->

                                    <!-- alert:actions -->
                                    <div class="flex flex-wrap items-center gap-3 mt-5">
                                        <button type="button"
                                            class="flex items-center gap-x-1 text-zinc-400 underline-offset-1 hover:underline"
                                            x-on:click="open = false">
                                            <span class="font-bold text-xs">فهمیدم</span>
                                        </button>
                                    </div><!-- end alert:actions -->
                                </div><!-- end alert:content -->
                            </div><!-- end alert -->

                            <form action="{{ route('user.password.update') }}" method="POST" class="space-y-5">
                                @csrf
                                @method('PUT')

                                <div class="flex flex-col gap-5">
                                    <div class="space-y-1 sm:w-1/2">
                                        <label for="current_password" class="block font-medium text-xs text-muted">پسورد
                                            فعلی</label>
                                        <input type="password" dir="ltr" id="current_password"
                                            name="current_password"
                                            class="form-input w-full h-11 !ring-0 !ring-offset-0 bg-secondary border-border focus:border-border rounded-xl text-sm text-foreground px-5" />
                                        @error('current_password')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="space-y-1 sm:w-1/2">
                                        <label for="password" class="block font-medium text-xs text-muted">پسورد
                                            جدید</label>
                                        <input type="password" dir="ltr" id="password" name="password"
                                            class="form-input w-full h-11 !ring-0 !ring-offset-0 bg-secondary border-border focus:border-border rounded-xl text-sm text-foreground px-5" />
                                        @error('password')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="space-y-1 sm:w-1/2">
                                        <label for="password_confirmation"
                                            class="block font-medium text-xs text-muted">تکرار پسورد جدید</label>
                                        <input type="password" dir="ltr" id="password_confirmation"
                                            name="password_confirmation"
                                            class="form-input w-full h-11 !ring-0 !ring-offset-0 bg-secondary border-border focus:border-border rounded-xl text-sm text-foreground px-5" />
                                    </div>
                                </div>

                                <div class="flex justify-end gap-5">
                                    <button type="submit"
                                        class="h-11 inline-flex items-center justify-center gap-3 bg-primary rounded-full text-white px-4 mr-auto">
                                        <span class="font-semibold text-sm">بروزرسانی</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-5 h-5">
                                            <path fill-rule="evenodd"
                                                d="M15.312 11.424a5.5 5.5 0 0 1-9.201 2.466l-.312-.311h2.433a.75.75 0 0 0 0-1.5H3.989a.75.75 0 0 0-.75.75v4.242a.75.75 0 0 0 1.5 0v-2.43l.31.31a7 7 0 0 0 11.712-3.138.75.75 0 0 0-1.449-.39Zm1.23-3.723a.75.75 0 0 0 .219-.53V2.929a.75.75 0 0 0-1.5 0V5.36l-.31-.31A7 7 0 0 0 3.239 8.188a.75.75 0 1 0 1.448.389A5.5 5.5 0 0 1 13.89 6.11l.311.31h-2.432a.75.75 0 0 0 0 1.5h4.243a.75.75 0 0 0 .53-.219Z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                            </form>

                            <script>
                                function deleteAvatar() {
                                    if (confirm('آیا مطمئن هستید که می‌خواهید تصویر پروفایل را حذف کنید؟')) {
                                        fetch('{{ route('user.avatar.delete') }}', {
                                                method: 'DELETE',
                                                headers: {
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                    'Accept': 'application/json',
                                                },
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                if (data.success) {
                                                    location.reload();
                                                }
                                            });
                                    }
                                }
                            </script>
                        </div><!-- end tabs:contents:tabTwo -->

                        <!-- tabs:contents:tabTwo -->
                        <div class="space-y-5" x-show="activeTab === 'tabFour'">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center gap-1">
                                    <div class="w-1 h-1 bg-foreground rounded-full"></div>
                                    <div class="w-2 h-2 bg-foreground rounded-full"></div>
                                </div>
                                <div class="font-black text-foreground">اطلاع رسانی</div>
                            </div>

                            <form action="#" class="space-y-5">
                                <div class="relative overflow-x-auto">
                                    <table class="w-full text-sm text-right">
                                        <thead class="text-xs text-muted uppercase border-b border-border">
                                            <tr>
                                                <th class="p-5">عملیات</th>
                                                <th class="p-5">پیامک</th>
                                                <th class="p-5">ایمیل</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="p-5">
                                                    <div class="font-medium text-sm text-muted">
                                                        تایید دیدگاه
                                                    </div>
                                                </td>
                                                <td class="p-5">
                                                    <input type="checkbox"
                                                        class="form-checkbox w-6 h-6 !ring-0 !ring-offset-0 bg-border border-0 rounded-lg cursor-pointer"
                                                        checked />
                                                </td>
                                                <td class="p-5">
                                                    <input type="checkbox"
                                                        class="form-checkbox w-6 h-6 !ring-0 !ring-offset-0 bg-border border-0 rounded-lg cursor-pointer" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-5">
                                                    <div class="font-medium text-sm text-muted">
                                                        بروزرسانی دوره
                                                    </div>
                                                </td>
                                                <td class="p-5">
                                                    <input type="checkbox"
                                                        class="form-checkbox w-6 h-6 !ring-0 !ring-offset-0 bg-border border-0 rounded-lg cursor-pointer"
                                                        checked />
                                                </td>
                                                <td class="p-5">
                                                    <input type="checkbox"
                                                        class="form-checkbox w-6 h-6 !ring-0 !ring-offset-0 bg-border border-0 rounded-lg cursor-pointer" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-5">
                                                    <div class="font-medium text-sm text-muted">
                                                        ورود به سایت
                                                    </div>
                                                </td>
                                                <td class="p-5">
                                                    <input type="checkbox"
                                                        class="form-checkbox w-6 h-6 !ring-0 !ring-offset-0 bg-border border-0 rounded-lg cursor-pointer" />
                                                </td>
                                                <td class="p-5">
                                                    <input type="checkbox"
                                                        class="form-checkbox w-6 h-6 !ring-0 !ring-offset-0 bg-border border-0 rounded-lg cursor-pointer"
                                                        checked />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-5">
                                                    <div class="font-medium text-sm text-muted">
                                                        خرید دوره
                                                    </div>
                                                </td>
                                                <td class="p-5">
                                                    <input type="checkbox"
                                                        class="form-checkbox w-6 h-6 !ring-0 !ring-offset-0 bg-border border-0 rounded-lg cursor-pointer" />
                                                </td>
                                                <td class="p-5">
                                                    <input type="checkbox"
                                                        class="form-checkbox w-6 h-6 !ring-0 !ring-offset-0 bg-border border-0 rounded-lg cursor-pointer"
                                                        checked />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="flex justify-end gap-5">
                                    <button type="submit"
                                        class="h-11 inline-flex items-center justify-center gap-3 bg-primary rounded-full text-white px-4 mr-auto">
                                        <span class="font-semibold text-sm">بروزرسانی</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-5 h-5">
                                            <path fill-rule="evenodd"
                                                d="M15.312 11.424a5.5 5.5 0 0 1-9.201 2.466l-.312-.311h2.433a.75.75 0 0 0 0-1.5H3.989a.75.75 0 0 0-.75.75v4.242a.75.75 0 0 0 1.5 0v-2.43l.31.31a7 7 0 0 0 11.712-3.138.75.75 0 0 0-1.449-.39Zm1.23-3.723a.75.75 0 0 0 .219-.53V2.929a.75.75 0 0 0-1.5 0V5.36l-.31-.31A7 7 0 0 0 3.239 8.188a.75.75 0 1 0 1.448.389A5.5 5.5 0 0 1 13.89 6.11l.311.31h-2.432a.75.75 0 0 0 0 1.5h4.243a.75.75 0 0 0 .53-.219Z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div><!-- end tabs:contents:tabTwo -->
                    </div><!-- end tabs:contents -->
                </div><!-- end tabs container -->
            </div>
        </div>
    </div>




@endsection
