<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Validation\Rule;

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
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->when($request->course_id, function ($query, $courseId) {
                $query->whereHas('chapter', function ($query) use ($courseId) {
                    $query->where('course_id', $courseId);
                });
            })
            ->when($request->filled('is_free'), function ($query) use ($request) {
                $query->where('is_free', $request->is_free);
            })
            ->orderBy('position')
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        $courses = Course::all();

        return view('admin.lessons.index', compact('lessons', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     *
     * @return view
     */
    public function create()
    {
        $chapters = Chapter::all();
        $courses = Course::all();
        return view('admin.lessons.create', compact('chapters', 'courses'));
    }



    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {
        $isHls = $request->input('video_type') === 'hls';

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'chapter_id' => 'required|exists:chapters,id',
            'slug' => 'required|string|max:255|unique:lessons,slug',
            'content' => 'nullable|string',
            'video_type' => 'required|in:normal,hls',
            'video_url' => [
                'required',
                'string',
                'max:2000',
                $isHls
                    ? 'regex:/^<script\s+id="[^"]+"\s+src="https:\/\/stream\.iranhls\.com\/Video\/Embed\/[^"]+"><\/script>$/i'
                    : 'url',
            ],
            'position' => 'nullable|integer|min:0',
            'file_link' => 'nullable|url|max:500',
            'is_free' => 'boolean',
            'is_hls' => 'boolean'
        ], [
            'video_url.required' => 'لینک یا اسکریپت ویدیو الزامی است.',
            'video_url.url' => 'برای ویدیوی عادی باید یک لینک معتبر وارد کنید.',
            'video_url.regex' => 'اسکریپت HLS باید از دامنه stream.iranhls.com و با فرمت embed معتبر باشد.',
        ]);

        // مقدار پیش‌فرض برای is_free
        $validated['is_free'] = $request->has('is_free') ? 1 : 0;
        $validated['is_hls'] = $isHls ? 1 : 0;
        unset($validated['video_type']);



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
    // متد edit
    public function edit($id)
    {
        $lesson = Lesson::with('chapter.course')->findOrFail($id);
        $courses = Course::all();
        // دریافت سرفصل‌های مربوط به دوره‌ی فعلی درس
        $chapters = Chapter::where('course_id', $lesson->chapter->course_id)->get();
        return view('admin.lessons.edit', compact('lesson', 'courses', 'chapters'));
    }

    // متد update
    public function update(Request $request, Lesson $lesson)
    {
        $isHls = $request->input('video_type') === 'hls';

        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'chapter_id' => 'required|exists:chapters,id',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('lessons', 'slug')->ignore($lesson->id),
            ],
            'content'    => 'nullable|string',
            'video_type' => 'required|in:normal,hls',
            'video_url'  => [
                'required',
                'string',
                'max:2000',
                $isHls
                    ? 'regex:/^<script\s+id="[^"]+"\s+src="https:\/\/stream\.iranhls\.com\/Video\/Embed\/[^"]+"><\/script>$/i'
                    : 'url',
            ],
            'position'   => 'nullable|integer|min:0',
            'file_link'  => 'nullable|url|max:500',
            'is_free'    => 'boolean',
            'is_hls'     => 'boolean'
        ], [
            'video_url.required' => 'لینک یا اسکریپت ویدیو الزامی است.',
            'video_url.url' => 'برای ویدیوی عادی باید یک لینک معتبر وارد کنید.',
            'video_url.regex' => 'اسکریپت HLS باید از دامنه stream.iranhls.com و با فرمت embed معتبر باشد.',
        ]);



        $validated['is_free'] = $request->has('is_free') ? 1 : 0;
        $validated['is_hls']  = $isHls ? 1 : 0;
        unset($validated['video_type']);


        $lesson->update($validated);



        return redirect()->route('admin.lessons.index')
            ->with('success', 'درس با موفقیت بروزرسانی شد.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lesson = Lesson::query()->findOrFail($id);
        $lesson->delete();

        return redirect()->route('admin.lessons.index')
            ->with('success', 'درس با موفقیت حذف شد.');
    }



    public  function course_ajax(Request $request)
    {


        $chapters = Chapter::query()->where('course_id', $request->course_id)->get();
        foreach ($chapters as $chapter):

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
