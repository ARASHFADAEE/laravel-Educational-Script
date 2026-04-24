<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class PostArchiveController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategory = $request->string('category')->toString();
        $search = trim($request->string('q')->toString());

        $categories = PostCategory::query()
            ->withCount([
                'posts' => fn ($query) => $query->where('status', 'published'),
            ])
            ->orderBy('name')
            ->get();

        $posts = Post::query()
            ->with(['user:id,name,avatar', 'post_categorie:id,name,slug'])
            ->where('status', 'published')
            ->when($selectedCategory, function ($query) use ($selectedCategory) {
                $query->whereHas('post_categorie', function ($categoryQuery) use ($selectedCategory) {
                    $categoryQuery->where('slug', $selectedCategory);
                });
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('body', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('frontend.blog-archive', [
            'posts' => $posts,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'search' => $search,
        ]);
    }
}
