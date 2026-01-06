@extends('admin.layouts.master')

@section('title', 'ویرایش پرداخت')

@section('main')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">ویرایش پرداخت #{{ $payment->id }}</h2>
    
    <form action="{{ route('admin.payments.update', $payment->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <!-- کاربر -->
        <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">
                کاربر <span class="text-red-500">*</span>
            </label>
            <select name="user_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                <option value="">انتخاب کاربر</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" 
                        {{ old('user_id', $payment->user_id) == $user->id ? 'selected' : '' }}>
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
                    <option value="{{ $course->id }}" 
                        {{ old('course_id', $payment->course_id) == $course->id ? 'selected' : '' }}>
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
                       value="{{ old('amount', $payment->amount) }}"
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
                <option value="online" {{ old('payment_method', $payment->payment_method) == 'online' ? 'selected' : '' }}>آنلاین</option>
                <option value="cash" {{ old('payment_method', $payment->payment_method) == 'cash' ? 'selected' : '' }}>نقدی</option>
                <option value="card" {{ old('payment_method', $payment->payment_method) == 'card' ? 'selected' : '' }}>کارت به کارت</option>
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
                <option value="pending" {{ old('status', $payment->status) == 'pending' ? 'selected' : '' }}>در انتظار</option>
                <option value="completed" {{ old('status', $payment->status) == 'completed' ? 'selected' : '' }}>تکمیل شده</option>
                <option value="failed" {{ old('status', $payment->status) == 'failed' ? 'selected' : '' }}>ناموفق</option>
            </select>
            @error('status')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- اطلاعات اضافی -->
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">اطلاعات تکمیلی</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-500 dark:text-gray-400">تاریخ ایجاد:</span>
                    <span class="text-gray-800 dark:text-gray-300 block">
                        {{ verta($payment->created_at)->format('Y/m/d H:i') }}
                    </span>
                </div>
                <div>
                    <span class="text-gray-500 dark:text-gray-400">آخرین بروزرسانی:</span>
                    <span class="text-gray-800 dark:text-gray-300 block">
                        {{ verta($payment->updated_at)->format('Y/m/d H:i') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- دکمه‌ها -->
        <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
            <div class="space-x-3 space-x-reverse">
                <a href="{{ route('admin.payments.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 dark:border-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                    بازگشت
                </a>
                <button type="button" 
                        onclick="if(confirm('آیا از حذف این پرداخت مطمئن هستید؟')) document.getElementById('delete-form').submit();"
                        class="px-4 py-2 border border-red-300 rounded-lg text-red-700 dark:border-red-600 dark:text-red-300 hover:bg-red-50 dark:hover:bg-red-900">
                    حذف پرداخت
                </button>
            </div>

            <div class="space-x-3 space-x-reverse">
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    بروزرسانی پرداخت
                </button>
            </div>
        </div>
    </form>

    <!-- فرم حذف -->
    <form id="delete-form" action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
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