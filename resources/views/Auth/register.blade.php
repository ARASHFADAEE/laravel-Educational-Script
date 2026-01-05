@extends('frontend.layouts.master')

@section('title', 'ورود و ثبت نام')
@section('content')



    <div class="min-h-screen flex items-center justify-center bg-background p-5">
        <div class="w-full max-w-sm space-y-5">
            <div class="bg-gradient-to-b from-secondary to-background rounded-3xl space-y-5 px-5 pb-5">
                <div class="bg-background rounded-b-3xl space-y-2 p-5">

                </div>

                <!-- auth:verification:form -->
                <form action="{{ route('auth.register') }}" class="space-y-3" method="POST">
                    @csrf
                    @if ($errors->any())
                        <div class="rounded-md bg-red-50 p-4">
                            <div class="flex">
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">
                                        خطا در ثبت نام
                                    </h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc pr-5 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-1">
                            <div class="w-1 h-1 bg-foreground rounded-full"></div>
                            <div class="w-2 h-2 bg-foreground rounded-full"></div>
                        </div>
                        <div class="font-black text-foreground">ثبت نام در سایت</div>
                    </div>
                    <div class="text-sm text-muted space-y-3">
                        <p>درود 👋</p>
                        <p>لطفا برای ورود مقادیر زیر را وارد کنید</p>
                    </div>

                    <!-- form:field:wrapper -->
                    <div class=" items-center relative">
                        <label for="name">نام و نام خانوادگی</label>
                        <input name="name" type="text" dir="ltr" placeholder="نام و نام خانوادگی"
                            class="form-input w-full h-11 !ring-0 !ring-offset-0 bg-secondary border-border focus:border-border rounded-xl text-sm text-foreground placeholder:text-right px-5" />

                        <label for="email">ایمیل:</label>
                        <input name="email" type="email" dir="ltr" placeholder="Arash@gmail.com"
                            class="form-input w-full h-11 !ring-0 !ring-offset-0 bg-secondary border-border focus:border-border rounded-xl text-sm text-foreground placeholder:text-right px-5" />
                        <label for="password">رمز عبور:</label>

                        <input name="password" type="password" dir="ltr" placeholder="*********"
                            class="form-input w-full h-11 !ring-0 !ring-offset-0 bg-secondary border-border focus:border-border rounded-xl text-sm text-foreground placeholder:text-right px-5" />
                        <label for="password_confirmation">تکرار رمز عبور:</label>

                            <input type="password" name="password_confirmation" dir="ltr" placeholder="*********"
                            class="form-input w-full h-11 !ring-0 !ring-offset-0 bg-secondary border-border focus:border-border rounded-xl text-sm text-foreground placeholder:text-right px-5" />
                    </div>
                    <!-- end form:field:wrapper -->

                    <!-- form:submit button -->
                    <button type="submit"
                        class="flex items-center justify-center gap-1 w-full h-10 bg-primary rounded-full text-primary-foreground transition-all hover:opacity-80 px-4">
                        <span class="font-semibold text-sm">برو بریم</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M14.78 14.78a.75.75 0 0 1-1.06 0L6.5 7.56v5.69a.75.75 0 0 1-1.5 0v-7.5A.75.75 0 0 1 5.75 5h7.5a.75.75 0 0 1 0 1.5H7.56l7.22 7.22a.75.75 0 0 1 0 1.06Z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <!-- end form:submit button -->
                </form>
                <!-- end auth:verification:form -->
            </div>
            <div class="bg-secondary rounded-xl space-y-5 p-5">
                <div class="font-medium text-xs text-center text-muted">
                    ورود شما به معنای پذیرش <a href="#"
                        class="text-foreground transition-colors hover:text-primary hover:underline">شرایط</a> و
                    <a href="#" class="text-foreground transition-colors hover:text-primary hover:underline">قوانین
                        حریم خصوصی</a> است.
                </div>
            </div>
        </div>
    </div>





@endsection
