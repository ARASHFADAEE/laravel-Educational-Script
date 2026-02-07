<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class CourseController extends Controller
{

    /**
     * Course Lists Page View
     * @return  view
     **/
    public function index()
    {
        $courses = Course::orderBy('id', 'desc')->paginate(10);
        return view('admin.courses.index', compact('courses'));
    }



    /**
     * Course Create Page View
     * @return  view
     **/
    public function create()
    {
        $categories = CourseCategory::all();

        return view('admin.courses.create', compact('categories'));
    }




    /**
     * Course Store Data
     * @return  Redirect
     * @return Message
     *
     *
     **/

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'time_course'   => 'required|integer|min:0',
            'level'=>'required',
            'slug'=>'required|unique:courses,slug',
            'status'=>'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'category_id' => 'required|exists:course_categories,id',
        ]);

        $filepath=Storage::disk('public')->put('courses', $request->file('thumbnail'));



        Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'slug' => $request->slug,
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'regular_price' => $request->regular_price,
            'sale_price'=>$request->sale_price,
            'level'=>$request->level,
            'status'=>$request->status,
            'time_course'=>$request->time_course,
            'thumbnail' => $filepath,
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'دوره با موفقیت ایجاد شد.');
    }



    /**
     * Course Edit Page View
     * @return  view
     *
     **/
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $categories = CourseCategory::all();
        return view('admin.courses.edit', compact('course', 'categories'));
    }


    /**
     *
     * Course Update  Data
     * @return  Redirect
     * @return Message
     *
     **/

    public function update(Request $request, $id)
{
    $course = Course::findOrFail($id);

    $validated = $request->validate([
        'title'         => 'required|string|max:255',
        'slug'          => 'required|string|max:255|unique:courses,slug,' . $course->id,
        'category_id'   => 'required|exists:course_categories,id', // نام جدول رو بر اساس migration چک کن
        'level'         => 'required|in:beginner,intermediate,advanced',
        'regular_price' => 'required|integer|min:0',
        'sale_price'    => 'required|integer|min:0',
        'time_course'   => 'required|integer|min:0',
        'status'        => 'required|in:draft,published',
        'thumbnail'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        'description'   => 'nullable|string',
    ]);

    // تولید خودکار slug اگر لازم باشه
    $validated['slug'] = Str::slug($validated['slug'] ?? $validated['title']);

    // مدیریت آپلود تصویر
    if ($request->hasFile('thumbnail')) {
        // حذف تصویر قدیمی
        if ($course->thumbnail && Storage::disk('public')->exists($course->thumbnail)) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        $validated['thumbnail'] = $request->file('thumbnail')->store('courses/thumbnails', 'public');
    }

    $course->update($validated);

    return redirect()->route('admin.courses.index')->with('success', 'دوره با موفقیت بروزرسانی شد.');
}




    /**
     *
     * Course Destroy  Data
     * @return  Redirect
     * @return Message
     *
     **/
    public function destroy($id){

            course::query()->findOrFail($id)->delete();

            return redirect()->route('admin.courses.index')->with('success','دوره با موفقیت حذف شد');

        }


}
