@extends('admin.layouts.master')

@section('title', 'ایجاد پرداخت جدید')

@section('main')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">ایجاد پرداخت جدید</h2>
    
    <form action="{{ route('admin.payments.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <!-- کاربر -->
        <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                کاربر <span class="text-red-500">*</span>
            </label>
            <select name="user_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                <option value="">انتخاب کاربر</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- دوره -->
        <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                دوره <span class="text-red-500">*</span>
            </label>
            <select name="course_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                <option value="">انتخاب دوره</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                        {{ $course->title }}
                    </option>
                @endforeach
            </select>
            @error('course_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- مبلغ -->
        <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                مبلغ <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <input type="number" 
                       name="amount" 
                       value="{{ old('amount') }}"
                       class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                       placeholder="مبلغ به تومان"
                       required>
                <span class="absolute left-3 top-2 text-gray-500">تومان</span>
            </div>
            @error('amount')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- روش پرداخت -->
        <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                روش پرداخت <span class="text-red-500">*</span>
            </label>
            <select name="payment_method" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                <option value="online" {{ old('payment_method') == 'online' ? 'selected' : '' }}>آنلاین</option>
                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>نقدی</option>
                <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>کارت به کارت</option>
            </select>
            @error('payment_method')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- وضعیت -->
        <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                وضعیت <span class="text-red-500">*</span>
            </label>
            <select name="status" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>در انتظار</option>
                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>تکمیل شده</option>
                <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>ناموفق</option>
            </select>
            @error('status')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- دکمه‌ها -->
        <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('admin.payments.index') }}" 
               class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 dark:border-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                بازگشت
            </a>

            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                ایجاد پرداخت
            </button>
        </div>
    </form>
</div>

@if($errors->any())
    <script>
        // نمایش خطاها در صورت وجود
        document.addEventListener('DOMContentLoaded', function() {
            @foreach($errors->all() as $error)
                toastr.error('{{ $error }}');
            @endforeach
        });
    </script>
@endif
@endsection