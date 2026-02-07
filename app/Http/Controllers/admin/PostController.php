<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostCategory as Category;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Show List Posts in Admin Panel
     *
     * @return view
     */
    public function index()
    {
        $posts = Post::paginate(10);

        return view('admin.posts.index', compact('posts'));
    }


    /**
     * Show Create Post Form Page in Admin Panel
     *
     * @return view
     */
    public function create()
    {

        $categories = category::all();
        return view('admin.posts.create', compact('categories'));
    }


    /**
     *  Handle Store Post in Admin Panel
     *
     * @return Redirect(Posts Lists) with message
     */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'nullable|string|unique:posts,slug',
            'category_id' => 'required|exists:post_categories,id',
            'body'        => 'required|string',
            'status'      => 'required|in:draft,published',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',

            // نام فیلدها باید با فرم شما مطابقت داشته باشد
            'seo_meta_title'       => 'nullable|string|max:255',
            'seo_meta_description' => 'nullable|string|max:500',
            'seo_meta_keywords'    => 'nullable|string',
        ]);

        $slug = $validated['slug'] ?? Str::slug($validated['title']);
        $validated['slug'] = $slug;

        // وضعیت بر اساس دکمه فشرده شده
        if ($request->input('action') === 'publish') {
            $validated['status'] = 'published';
        } else {
            $validated['status'] = 'draft';
        }

        // آپلود تصویر اگر وجود دارد
        $file_path = null;
        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            $file_path = Storage::disk('public')->put('blogs', $request->thumbnail);
        }

        // ایجاد مقاله
        $post = Post::create([
            'title'       => $validated['title'],
            'slug'        => $validated['slug'],
            'category_id' => $validated['category_id'],
            'body'        => $validated['body'],
            'status'      => $validated['status'],
            'thumbnail'   => $file_path,
            'user_id'     => Auth::id()
        ]);

        // ایجاد رکورد SEO - اصلاح شده
        $post->seo()->create([
            'meta_title'       => $request->input('seo_meta_title', $validated['title']),
            'meta_description' => $request->input('seo_meta_description', Str::limit(strip_tags($validated['body']), 160)),
            'meta_keywords'    => $request->input('seo_meta_keywords', ''),
            'metable_type'     => 'App\Models\Post', // نام کامل کلاس
            'metable_id'       => $post->id
        ]);

        return redirect()->route('admin.posts.index')
            ->with('success', 'مقاله با موفقیت ایجاد شد.');
    }

    /**
     * Show Edit Post Form Page in Admin Panel
     *
     * @return view
     */
    public function edit($id)
    {
        $post = Post::query()->findOrFail($id);
        $categories = category::all();

        return view('admin.posts.edit', compact('post', 'categories'));
    }



    /**
     * Handle Update Post Form in Admin Panel
     *
     * @return Redirect(Posts Lists) with message
     */
    public function update(Request $request)
    {
        // دریافت post_id از درخواست
        $postId = $request->input('post_id');

        if (!$postId) {
            return redirect()->back()->withErrors(['error' => 'شناسه مقاله مشخص نشده است.']);
        }

        // پیدا کردن مقاله
        $post = Post::findOrFail($postId);

        // Validation
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'nullable|string|unique:posts,slug,' . $postId, // اصلاح شده
            'category_id' => 'required|exists:post_categories,id',
            'body'        => 'required|string',
            'status'      => 'required|in:draft,published',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',

            // تغییر نام فیلدها به match فرم
            'seo.meta_title'       => 'nullable|string|max:255',
            'seo.meta_description' => 'nullable|string|max:500',
            'seo.meta_keywords'    => 'nullable|string',
        ]);

        // تنظیم slug
        $slug = $validated['slug'] ?? Str::slug($validated['title']);
        $validated['slug'] = $slug;

        // وضعیت بر اساس دکمه فشرده شده
        if ($request->input('action') === 'publish') {
            $validated['status'] = 'published';
        } else {
            $validated['status'] = 'draft';
        }

        // آپلود تصویر جدید اگر وجود دارد
        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            // حذف تصویر قبلی
            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }

            // ذخیره تصویر جدید
            $validated['thumbnail'] = Storage::disk('public')->put('blogs', $request->thumbnail);
        } else {
            // نگه داشتن تصویر قبلی
            $validated['thumbnail'] = $post->thumbnail;
        }

        // به‌روزرسانی مقاله
        $post->update([
            'title'       => $validated['title'],
            'slug'        => $validated['slug'],
            'category_id' => $validated['category_id'],
            'body'        => $validated['body'],
            'status'      => $validated['status'],
            'thumbnail'   => $validated['thumbnail'],
        ]);

        // به‌روزرسانی یا ایجاد SEO
        $seoData = [
            'meta_title'       => $request->input('seo.meta_title', $validated['title']),
            'meta_description' => $request->input('seo.meta_description', Str::limit(strip_tags($validated['body']), 160)),
            'meta_keywords'    => $request->input('seo.meta_keywords', ''),
        ];

        // اگر SEO رکورد وجود دارد، آن را به‌روزرسانی کن، در غیر این صورت ایجاد کن
        if ($post->seo) {
            $post->seo()->update($seoData);
        } else {
            $post->seo()->create($seoData);
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'مقاله با موفقیت به‌روزرسانی شد.');
    }



    /**
     * Handle Destroy Post Form in Admin Panel
     *
     * @return Redirect(Posts Lists) with message
     */
    public function destroy($id)
    {
        $post = Post::query()->findOrFail($id);

        $post->delete();

        return redirect()->back()->with('success', 'مقاله با موفقیت حذف شد');
    }



    /**
     * Handle Search Ajax FrontEnd
     */
    public function Search(Request $request){
    $q = $request->query('q');

    $Posts = Post::where('title', 'LIKE', "%{$q}%")
        ->select('id','title','slug')
        ->get();

    return response()->json($Posts);

    }
}
