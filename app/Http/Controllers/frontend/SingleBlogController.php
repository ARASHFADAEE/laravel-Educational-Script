<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
class SingleBlogController extends Controller
{
    /**
     * single blog show
     * @return view
     */

    public function show($slug){


        $post=Post::query()->where('slug','=',$slug)
        ->with(['post_categorie:id,name,slug','user:id,name,avatar,bio'])->first();

        $comments = Comment::with(['user', 'replies.user'])
            ->where('post_id', $post->id)
            ->whereNull('parent_id')
            ->orderBy('created_at', 'desc')
            ->paginate(10);





        return view('frontend.single',compact('post','comments'));




    }
}
