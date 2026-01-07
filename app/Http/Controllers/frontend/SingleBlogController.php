<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\seo_meta;

class SingleBlogController extends Controller
{
    /**
     * single blog show
     * @return view
     */

    public function show($slug){

        $posts=Post::query()->where('slug','=',$slug)
        ->with(['post_categorie:id,name,slug','user:id,name,avatar,bio'])->get();





        return view('frontend.single',compact('posts'));




    }
}
