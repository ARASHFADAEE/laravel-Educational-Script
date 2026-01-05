<?php

namespace App\Http\Controllers\admin;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\post_categorie as category;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function index(){
        $posts=Post::paginate(10);

        return view('admin.posts.index',compact('posts'));
    }
    

    public function create(){
        
        $categories=category::all();
        return view('admin.posts.create',compact('categories'));
    }

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

public function destroy($id){
    $post=Post::query()->findOrFail($id);

    $post->delete();

    return redirect()->back()->with('success','مقاله با موفقیت حذف شد');

}


}
