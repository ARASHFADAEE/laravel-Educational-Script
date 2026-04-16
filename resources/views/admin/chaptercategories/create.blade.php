@extends('admin.layouts.master')



@section('title', 'افزودن سرفصل')

@section('main')

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 max-w-3xl">

        <h3 class="text-white">ایجاد سرفصل دوره</h3>

        <form action="" method="POST" class="space-y-6 flex flex-col p-12">
            @csrf

            <!-- Name -->
            <div style="margin-bottom: 10px">
                <label class="form-label text-white">نام سرفصل</label>
                <input type="text" name="name" class="form-input text-black w-full" placeholder="نام دسته بندی" value="{{old('name')}}">
                @error('name')
                    <p class="form-error bg-red-700">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="form-label text-white">انتخاب دوره</label>
                <select type="text" name="course" class="form-input text-black  w-full"  value="{{old('course')}}" style="
    margin-bottom: 33px;
">
                    <option value="">درس اول</option>
                    <option value="">درس اول</option>

                @error('course')
                    <p class="form-error bg-red-700">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="form-label text-white">توضیحات فصل</label>
                <input name="description" class="w-full " ></texarea>
                @error('description')
                    <p class="form-error bg-red-700">{{ $message }}</p>
                @enderror
            </div>

 





            <!-- Actions -->
            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{route('admin.post.categories.index')}}" class="btn-secondary text-white">
                    بازگشت
                </a>

                <button type="submit" class=" text-white p-3 rounded" style="background: #2a77ff;">
                    ذخیره تغییرات
                </button>
            </div>

        </form>

    </div>





@endsection
