<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Course;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    /**
     * Display a listing of chapters.
     */
    public function index()
    {
        $chapters = Chapter::query()
            ->with('course')
            ->orderBy('course_id')
            ->orderBy('position')
            ->orderByDesc('id')
            ->paginate(20);

        return view('admin.chaptercategories.index', compact('chapters'));
    }

    /**
     * Show the form for creating a new chapter.
     */
    public function create()
    {
        $courses = Course::query()->orderByDesc('id')->get();

        return view('admin.chaptercategories.create', compact('courses'));
    }

    /**
     * Store a newly created chapter.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'position' => 'nullable|integer|min:0',
        ]);

        Chapter::query()->create($validated);

        return redirect()->route('admin.chapters.index')
            ->with('success', 'سرفصل با موفقیت ایجاد شد.');
    }

    /**
     * Show the form for editing the specified chapter.
     */
    public function edit($id)
    {
        $chapter = Chapter::query()->findOrFail($id);
        $courses = Course::query()->orderByDesc('id')->get();

        return view('admin.chaptercategories.edit', compact('chapter', 'courses'));
    }

    /**
     * Update the specified chapter.
     */
    public function update(Request $request, $id)
    {
        $chapter = Chapter::query()->findOrFail($id);

        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'position' => 'nullable|integer|min:0',
        ]);

        $chapter->update($validated);

        return redirect()->route('admin.chapters.index')
            ->with('success', 'سرفصل با موفقیت بروزرسانی شد.');
    }

    /**
     * Remove the specified chapter.
     */
    public function destroy($id)
    {
        $chapter = Chapter::query()->findOrFail($id);
        $chapter->delete();

        return redirect()->route('admin.chapters.index')
            ->with('success', 'سرفصل با موفقیت حذف شد.');
    }
}
