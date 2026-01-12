<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use Illuminate\Http\Request;
use App\Models\lesson;
use App\Models\course;
class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return view
     */
     public function index(Request $request)
{
    $lessons = Lesson::query()
        ->with('chapter')
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
        ->paginate(30);






    return view('admin.lessons.index', compact('lessons'));
}

    /**
     * Show the form for creating a new resource.
     *
     *
     * @return view
     */
    public function create()
    {
        $chapters=Chapter::all() ;
        $courses = Course::all();
        return view('admin.lessons.create', compact('chapters','courses'));
    }



    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'chapter_id' => 'required|exists:chapters,id',
            'slug' => 'required|string|max:255|unique:lessons,slug',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url|max:500',
            'position' => 'nullable|integer|min:0',
            'File_link' => 'nullable|url|max:500',
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
            'title' => 'required|string|max:255',
            'chapter_id' => 'required|exists:chapters,id',
            'slug' => 'required|string|max:255' . $lesson->id,
            'content' => 'nullable|string',
            'video_url' => 'nullable|url|max:500',
            'position' => 'nullable|integer|min:0',
            'File_link' => 'nullable|url|max:500',
            'is_free' => 'boolean'
        ]);



        $validated['is_free'] = $request->has('is_free') ? 1 : 0;

        Lesson::query()->update([
            'title' => $validated['title'],
            'chapter_id' => $validated['chapter_id'],
            'slug' => $validated['slug'],
            'content' => $validated['content'],
            'video_url' => $validated['video_url'],
            'is_free' => $validated['is_free'],
            'position' => $validated['position'],
        ]);

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



    public  function course_ajax(Request $request)
    {


        $chapters=Chapter::query()->where('course_id',$request->course_id)->get();
        foreach($chapters as $chapter):

        ?>
        <option value="<?= $chapter->id ?>" <?= old('course_id') == $chapter->id ? 'selected' : '' ?>>
        <?= $chapter->title ?>
        </option>
        <?php
        endforeach;

        ?>




<?php



    }
}
