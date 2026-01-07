@extends('admin.layouts.master')



@section('title', 'ویرایش کاربر')

@section('main')

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 max-w-3xl">

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6 flex flex-col p-12"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label class="form-label text-white">نام و نام خانوادگی</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input text-black w-full"
                    placeholder="نام کاربر">
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- bio textarea --}}
            <div>
                <label class="form-label text-white">بیوگرافی</label>
                <textarea type="text" name="bio" class="form-input text-black  w-full" placeholder="من یک برنامه نویس خوشحالم" value="{{old('bio',$user->bio)}}"></textarea>
                @error('bio')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="form-label text-white">ایمیل</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input text-black  w-full"
                    placeholder="example@email.com">
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role -->
            <div>
                <label class="form-label text-white">نقش کاربر</label>
                <select name="role" class="form-input text-black  w-full">
                    <option class="text-black" value="admin" @selected($user->role === 'admin')>ادمین</option>
                    <option class="text-black" value="user" @selected($user->role === 'user')>کاربر عادی</option>
                </select>
                @error('role')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="form-label text-white">
                    رمز عبور
                    <span class="text-xs text-gray-400 ">(در صورت عدم تغییر خالی بگذارید)</span>
                </label>
                <input type="password" name="password" class="form-input  w-full" placeholder="********">
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="form-label text-white">
                    تکرار رمز عبور
                    <span class="text-xs text-gray-400 ">(در صورت عدم تغییر خالی بگذارید)</span>
                </label>
                <input type="password" name="password_confirmation" class="form-input  w-full" placeholder="********">
                @error('password_confirmation')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
<div>
    <label class="form-label text-white">عکس آواتار</label>

    <!-- نمایش عکس فعلی (اگر وجود داشته باشد) -->
    @if($user->avatar)
        <div class="mt-2 mb-4">
            <p class="text-sm text-gray-400 mb-2">عکس فعلی:</p>
            <img 
                src="{{ asset('storage/' . $user->avatar) }}" 
                alt="آواتار فعلی کاربر" 
                class="w-32 h-32 object-cover rounded-full border-2 border-gray-300 shadow-sm"
            >
        </div>
    @else
        <div class="mt-2 mb-4">
            <p class="text-sm text-gray-500">هیچ عکسی انتخاب نشده است</p>
        </div>
    @endif

    <!-- فیلد آپلود عکس جدید -->
    <input 
        type="file" 
        name="avatar" 
        accept="image/*" 
        class="form-input text-black w-full"
    >
    
    <p class="mt-1 text-xs text-gray-500">
        فرمت‌های مجاز: jpg, jpeg, png, gif, webp (حداکثر ۲ مگابایت)
    </p>

    @error('avatar')
        <p class="form-error mt-1">{{ $message }}</p>
    @enderror
</div>


            <!-- Actions -->
            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('admin.users.index') }}" class="btn-secondary text-white">
                    بازگشت
                </a>

                <button type="submit" class=" text-white p-3 rounded" style="background: #2a77ff;">
                    ذخیره تغییرات
                </button>
            </div>

        </form>

    </div>





@endsection
