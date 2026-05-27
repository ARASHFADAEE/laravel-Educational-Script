@extends('frontend.layouts.master')

@section('title', 'تکمیل خرید اشتراک')
@section('description', 'تکمیل اطلاعات و پرداخت پلن اشتراک')

@section('content')
<main class="flex-auto py-12">
    <div class="container mx-auto max-w-xl px-4">
        <div class="rounded-2xl bg-white p-6 shadow-lg dark:bg-gray-800">
            <h1 class="mb-2 text-2xl font-black text-gray-900 dark:text-white">تکمیل خرید {{ $plan->name }}</h1>
            <p class="mb-6 text-sm text-gray-600 dark:text-gray-400">
                مدت اشتراک: {{ $plan->duration_days }} روز، مبلغ: {{ number_format($price) }} تومان
            </p>

            @if(session('error'))
                <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('subscription.plan.zibal') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="subscription_plan_id" value="{{ $plan->id }}">

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">نام</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $defaultFirstName) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-800 focus:border-blue-500 focus:outline-none">
                        @error('first_name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">نام خانوادگی</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $defaultLastName) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-800 focus:border-blue-500 focus:outline-none">
                        @error('last_name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">شماره موبایل</label>
                    <input type="text" name="phone" value="{{ old('phone', $defaultPhone) }}" placeholder="09xxxxxxxxx"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-800 focus:border-blue-500 focus:outline-none">
                    @error('phone')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between gap-3 pt-4">
                    <a href="{{ route('subscription.index') }}"
                        class="rounded-lg border border-gray-300 px-5 py-3 text-sm font-bold text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300">
                        بازگشت
                    </a>
                    <button type="submit" style="
    background: #1e4ed8;
    color:#ffff
"
                        class="rounded-lg bg-blue-600 px-6 py-3 text-sm font-bold text-white transition hover:bg-blue-700">
                        پرداخت اشتراک
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
