@extends('frontend.layouts.master')

@section('title', 'خرید اشتراک')
@section('description', 'خرید پلن اشتراک و دسترسی به تمام دوره‌های فیلتر شده')

@section('content')

<main class="flex-auto py-12">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-3">
                اشتراک شما
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400">
                پلن‌های اشتراک را انتخاب کنید و به تمام دوره‌های اشتراک‌پذیر دسترسی پیدا کنید
            </p>
        </div>

        <!-- Alert -->
        @if($errors->any())
            <div class="mb-8 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg">
                <p class="text-red-800 dark:text-red-300">{{ $errors->first() }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-8 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg">
                <p class="text-red-800 dark:text-red-300">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Plans Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-2xl mx-auto mb-12">
            @forelse($plans as $plan)
                @php
                    $price = $planPrices[$plan->id] ?? 0;
                    $isPopular = $loop->iteration === 2; // Make 3-month plan popular
                @endphp

                <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden transition-all hover:shadow-xl hover:scale-105"
                    :class="{ 'ring-2 ring-indigo-500 scale-105': {{ $isPopular ? 'true' : 'false' }} }">
                    
                    @if($isPopular)
                        <div class="absolute top-0 right-0 bg-indigo-600 text-white px-4 py-1 rounded-bl-lg text-sm font-bold">
                            محبوب‌ترین
                        </div>
                    @endif

                    <div class="p-8">
                        <!-- Plan Name -->
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                            {{ $plan->name }}
                        </h2>

                        <!-- Duration -->
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                            {{ $plan->duration_days }} روز دسترسی کامل
                        </p>

                        <!-- Price -->
                        <div class="mb-8">
                            @if($price > 0)
                                <div class="flex items-baseline gap-2">
                                    <span class="text-4xl font-bold text-gray-900 dark:text-white">
                                        {{ number_format($price) }}
                                    </span>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">تومان</span>
                                </div>
                            @else
                                <span class="text-lg text-red-600 dark:text-red-400">قیمت تعیین نشده</span>
                            @endif
                        </div>

                        <!-- Features -->
                        <ul class="space-y-3 mb-8 text-gray-700 dark:text-gray-300 text-sm">
                            <li class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>دسترسی به تمام دوره‌های اشتراک‌پذیر</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>دسترسی {{ $plan->duration_days }} روزه</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>دانلود محتوا (در صورت امکان)</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>پشتیبانی ۲۴/۷</span>
                            </li>
                        </ul>

                        <!-- CTA Button -->
                        @if($price > 0)
                            <a href="{{ route('subscription.checkout', ['plan_id' => $plan->id]) }}" style="
    background: #1e4ed8;
    color:#ffff
"
                                class="w-full block text-center py-3 rounded-lg font-bold transition-all"
                                :class="{ 'bg-indigo-600 hover:bg-indigo-700 text-white': {{ $isPopular ? 'true' : 'false' }}, 'bg-gray-200 hover:bg-gray-300 text-gray-900 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white': {{ $isPopular ? 'false' : 'true' }} }">
                                ثبت سفارش  
                            </a>
                        @else
                            <button disabled class="w-full py-3 rounded-lg font-bold bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed">
                                قیمت تعیین نشده
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-12">
                    <p class="text-gray-600 dark:text-gray-400 text-lg">هیچ پلانی موجود نیست.</p>
                </div>
            @endforelse
        </div>

        <!-- Info Section -->
        <div class="max-w-2xl mx-auto bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-xl p-6">
            <h3 class="font-bold text-blue-900 dark:text-blue-300 mb-3"> درباره اشتراک:</h3>
            <ul class="list-disc list-inside space-y-2 text-blue-800 dark:text-blue-200 text-sm">
                <li>پس از خریداری، اشتراک برای {{ $plans->first()?->duration_days ?? '۳۰' }} روز فعال خواهد شد.</li>
                <li>می‌توانید در طول دوره اشتراک، به تمام دوره‌های اشتراک‌پذیر دسترسی داشته باشید.</li>
                <li>برای تمدید اشتراک، می‌توانید از همین صفحه پلن جدیدی خریداری کنید.</li>
                <li>هیچ هزینه پنهانی نیست و می‌توانید به هر وقت لغو کنید.</li>
            </ul>
        </div>
    </div>
</main>

@endsection
