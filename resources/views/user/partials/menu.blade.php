                    <ul class="flex flex-col space-y-3 bg-secondary rounded-2xl p-5">
                        <li>
                            <a href="{{route('user.dashboard')}}"
                                class="w-full h-11 inline-flex items-center text-right gap-3 {{ request()->routeIs('user.dashboard') ? 'bg-primary text-white ' : 'bg-background text-black hover:bg-opacity-80' }} rounded-full  px-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M1.5 7.125c0-1.036.84-1.875 1.875-1.875h6c1.036 0 1.875.84 1.875 1.875v3.75c0 1.036-.84 1.875-1.875 1.875h-6A1.875 1.875 0 0 1 1.5 10.875v-3.75Zm12 1.5c0-1.036.84-1.875 1.875-1.875h5.25c1.035 0 1.875.84 1.875 1.875v8.25c0 1.035-.84 1.875-1.875 1.875h-5.25a1.875 1.875 0 0 1-1.875-1.875v-8.25ZM3 16.125c0-1.036.84-1.875 1.875-1.875h5.25c1.036 0 1.875.84 1.875 1.875v2.25c0 1.035-.84 1.875-1.875 1.875h-5.25A1.875 1.875 0 0 1 3 18.375v-2.25Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-semibold text-xs">پیشخوان</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{Route('user.courses')}}"
                                class="w-full h-11 inline-flex items-center text-right gap-3 {{ request()->routeIs('user.courses') ? 'bg-primary text-white ' : 'bg-background text-gray-700 hover:bg-opacity-80' }} rounded-full text-muted transition-colors hover:bg-primary hover:text-primary-foreground px-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5">
                                    </path>
                                </svg>
                                <span class="font-semibold text-xs">دوره ها</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{route('user.payments')}}"
                                class="w-full h-11 inline-flex items-center text-right gap-3 {{ request()->routeIs('user.payments') ? 'bg-primary text-white ' : 'bg-background text-gray-700 hover:bg-opacity-80' }} rounded-full text-muted transition-colors hover:bg-primary hover:text-primary-foreground px-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 12a2.25 2.25 0 0 0-2.25-2.25H15a3 3 0 1 1-6 0H5.25A2.25 2.25 0 0 0 3 12m18 0v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 9m18 0V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v3">
                                    </path>
                                </svg>
                                <span class="font-semibold text-xs">مالی و اشتراک</span>
                            </a>
                        </li>




                        <li>
                            <a href="{{route('user.profile')}}"
                                class="w-full h-11 inline-flex items-center text-right gap-3 {{ request()->routeIs('user.profile') ? 'bg-primary text-white ' : 'bg-background text-gray-700 hover:bg-opacity-80' }} rounded-full text-muted transition-colors hover:bg-primary hover:text-primary-foreground px-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125">
                                    </path>
                                </svg>
                                <span class="font-semibold text-xs">ویرایش پروفایل</span>
                            </a>
                        </li>

                        <li>

                            <form action="{{route('auth.logout')}}" method="POST">
                                @csrf
                            <button type="submit"
                                class="w-full h-11 inline-flex items-center text-right gap-3 bg-background rounded-full text-muted transition-colors hover:bg-primary hover:text-primary-foreground px-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15">
                                    </path>
                                </svg>
                                <span class="font-semibold text-xs">خروج از حساب</span>
                            </button>
                            </form>
                        </li>
                    </ul>