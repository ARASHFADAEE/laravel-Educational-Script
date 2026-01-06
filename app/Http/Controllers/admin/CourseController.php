<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\course;
use App\Models\course_categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class CourseController extends Controller
{
    public function index()
    {
        $courses = course::orderBy('id', 'desc')->paginate(10);
        return view('admin.courses.index', compact('courses'));
    }


    public function create()
    {
        $categories = course_categorie::all();

        return view('admin.courses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'level'=>'required',
            'slug'=>'required|unique:courses,slug',
            'status'=>'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'category_id' => 'required|exists:course_categories,id',
        ]);

        $filepath=Storage::disk('public')->put('courses', $request->file('thumbnail'));



        course::create([
            'title' => $request->title,
            'description' => $request->description,
            'slug' => $request->slug,
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'price' => $request->price,
            'level'=>$request->level,
            'status'=>$request->status,
            'thumbnail' => $filepath,
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'دوره با موفقیت ایجاد شد.');
    }

    public function edit($id)
    {
        $course = course::findOrFail($id);
        $categories = course_categorie::all();
        return view('admin.courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, $id)
{
    $course = Course::findOrFail($id); // بهتره نام مدل PascalCase باشه (Course)

    $validated = $request->validate([
        'title'         => 'required|string|max:255',
        'slug'          => 'required|string|max:255|unique:courses,slug,' . $course->id,
        'category_id'   => 'required|exists:course_categories,id', // نام جدول رو بر اساس migration چک کن
        'level'         => 'required|in:beginner,intermediate,advanced',
        'price'         => 'required|integer|min:0',
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
}
