@extends('frontend.layouts.master')

@section('title', 'ثبت‌نام سریع')
@section('content')

@php
    $otpPendingPhone = session('otp_pending_phone');
    $otpMaskedPhone = session('otp_pending_masked');
@endphp

<div class="min-h-screen flex items-center justify-center bg-background p-5">
    <div class="w-full max-w-md space-y-5">
        <div class="bg-gradient-to-b from-secondary to-background rounded-3xl space-y-6 px-6 pb-8 border border-border shadow-xl">
            <div class="pt-8 text-center">
                <h1 class="text-2xl font-black text-foreground">ثبت‌نام سریع</h1>
                <p class="text-sm text-muted mt-2">فقط با شماره موبایل، در کمتر از ۳۰ ثانیه ثبت‌نام کنید.</p>
            </div>

            <form action="{{ route('auth.login') }}" method="POST" class="space-y-5" id="register-form" 
                x-data="{ 
                    mode: 'otp',
                    isOtpSent: {{ $otpPendingPhone ? 'true' : 'false' }}
                }">
                @csrf
                <input type="hidden" name="auth_mode" value="otp">

                @if ($errors->any())
                    <div class="rounded-2xl bg-red-50 border border-red-100 p-4 text-sm text-red-700 animate-in fade-in zoom-in duration-300">
                        <ul class="list-disc pr-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Step 1: Phone Input -->
                <div class="space-y-2" x-show="!isOtpSent" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                    <label for="identifier_otp" class="text-sm font-semibold text-foreground pr-1">شماره موبایل</label>
                    <input
                        id="identifier_otp"
                        name="identifier"
                        type="text"
                        dir="ltr"
                        value="{{ old('identifier', $otpPendingPhone) }}"
                        placeholder="09123456789"
                        class="form-input w-full h-12 bg-secondary border-border focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl text-base text-foreground transition-all px-4"
                        oninput="this.value = this.value.replace(/[^0-9۰-۹]/g, '')"
                        :disabled="isOtpSent"
                    />
                    <p class="text-[11px] text-muted pr-1">کد تایید به این شماره ارسال خواهد شد.</p>
                </div>

                <!-- Step 2: Code Input -->
                <div class="space-y-5" x-show="isOtpSent" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between px-1">
                            <label for="otp_code" class="text-sm font-semibold text-foreground">کد تایید ۶ رقمی</label>
                            <button type="button" @click="isOtpSent = false" class="text-xs text-primary hover:underline flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                ویرایش شماره
                            </button>
                        </div>
                        
                        <input
                            id="otp_code"
                            name="otp_code"
                            type="text"
                            dir="ltr"
                            inputmode="numeric"
                            maxlength="6"
                            value="{{ old('otp_code') }}"
                            placeholder="------"
                            class="form-input w-full h-14 bg-secondary border-border focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl text-center text-3xl font-black tracking-[0.5em] text-foreground transition-all px-4"
                            :disabled="!isOtpSent"
                        />
                        
                        <div class="flex items-center gap-2 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-xs text-emerald-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>کد تایید برای شماره <b>{{ $otpMaskedPhone ?? $otpPendingPhone }}</b> پیامک شد.</span>
                        </div>

                        <input type="hidden" name="identifier" value="{{ $otpPendingPhone }}" :disabled="!isOtpSent">
                    </div>
                </div>

                <button
                    type="submit"
                    class="group relative flex items-center justify-center w-full h-12 bg-primary rounded-2xl text-primary-foreground shadow-lg shadow-primary/20 hover:shadow-primary/30 hover:scale-[1.02] active:scale-[0.98] transition-all overflow-hidden"
                >
                    <span class="relative z-10 font-bold" 
                        x-text="isOtpSent ? 'تایید و ایجاد حساب' : 'دریافت کد تایید'"></span>
                    <div class="absolute inset-0 bg-white/10 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                </button>

                <div class="pt-4 flex items-center justify-center gap-2 text-sm border-t border-border/50">
                    <span class="text-muted">اکانت دارید؟</span>
                    <a class="text-primary font-bold hover:underline" href="{{ route('auth.show') }}">وارد شوید</a>
                </div>
            </form>
        </div>

        <div class="text-center px-6">
            <p class="text-[10px] text-muted leading-relaxed">
                با ثبت‌نام، شما <a href="#" class="text-foreground hover:underline">شرایط و قوانین</a> و <a href="#" class="text-foreground hover:underline">سیاست حریم خصوصی</a> ما را می‌پذیرید.
            </p>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
