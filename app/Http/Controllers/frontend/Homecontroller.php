<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\course;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\payment;


class Homecontroller extends Controller
{

    public function home_data()
    {
        $courses = Course::with('course_categorie:id,name')
            ->withCount('lessons')->with('user')->latest()
            ->paginate(12);


        $posts = Post::with([
            'user:id,name,avatar',
            'post_categorie:id,name'
        ])
            ->select('id', 'title', 'slug', 'thumbnail', 'created_at', 'user_id', 'category_id')
            ->paginate(4);


        return [
            'courses' => $courses,
            'posts' => $posts

        ];


    }

    public function index()
    {




        return view('frontend.index', $this->home_data());
    }

    
}
