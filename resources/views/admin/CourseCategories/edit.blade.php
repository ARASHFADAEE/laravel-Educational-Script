@extends('admin.layouts.master')



@section('title', 'ویرایش  دسته بندی دوره')

@section('main')

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 max-w-3xl">

        <form action="{{route('admin.course_categories.update',$category->id)}}" method="POST" class="space-y-6 flex flex-col p-12">
            @csrf
            @method('put')

            <!-- Name -->
            <div>
                <label class="form-label text-white">نام دسته بندی</label>
                <input type="text" name="name" class="form-input w-full" placeholder="نام دسته بندی" value="{{$category->name}}">
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="form-label text-white">اسلاگ</label>
                <input type="text" name="slug" class="form-input  w-full" placeholder="laravel" value="{{$category->slug}}">
                @error('slug')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>





            <!-- Actions -->
            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{route('admin.course_categories.index')}}" class="btn-secondary text-white">
                    بازگشت
                </a>

                <button type="submit" class=" text-white p-3 rounded" style="background: #2a77ff;">
                    ذخیره تغییرات
                </button>
            </div>

        </form>

    </div>





@endsection
