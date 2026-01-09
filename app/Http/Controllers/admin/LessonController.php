<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\lesson;
use App\Models\course;
class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    $lessons = Lesson::query()
        ->with('course') // eager loading برای رابطه course
        ->when($request->search, function($query, $search) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
        })
        ->when($request->course_id, function($query, $courseId) {
            $query->where('course_id', $courseId);
        })
        ->when($request->has('is_free'), function($query) use ($request) {
            $query->where('is_free', $request->is_free);
        })
        ->orderBy('position')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    // اگر نیاز به لیست دوره‌ها برای dropdown دارید
    $courses = Course::all();

    return view('admin.lessons.index', compact('lessons', 'courses'));
}

    /**
     * Show the form for creating a new resource.
     */
    // نمایش فرم ایجاد
    public function create()
    {
        $courses = Course::all();
        return view('admin.lessons.create', compact('courses'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:lessons,slug',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url|max:500',
            'position' => 'nullable|integer|min:0',
            'is_free' => 'boolean'
        ]);

        // مقدار پیش‌فرض برای is_free
        $validated['is_free'] = $request->has('is_free') ? 1 : 0;

        Lesson::create($validated);

        return redirect()->route('admin.lessons.index')
            ->with('success', 'درس با موفقیت ایجاد شد.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // نمایش فرم ویرایش
    public function edit($id)

    {   $lesson=lesson::query()->findOrFail($id);
        $courses = Course::all();
        return view('admin.lessons.edit', compact('lesson', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    // بروزرسانی درس
    public function update(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255' . $lesson->id,
            'content' => 'nullable|string',
            'video_url' => 'nullable|url|max:500',
            'position' => 'nullable|integer|min:0',
            'is_free' => 'boolean'
        ]);

        $validated['is_free'] = $request->has('is_free') ? 1 : 0;

        $lesson->update($validated);

        return redirect()->route('admin.lessons.index')
            ->with('success', 'درس با موفقیت بروزرسانی شد.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lesson=lesson::query()->findOrFail($id);
        $lesson->delete();

        return redirect()->route('admin.lessons.index')
            ->with('success', 'درس با موفقیت حذف شد.');
    }
}
