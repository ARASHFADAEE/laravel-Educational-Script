<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;


class HomeController extends Controller
{

    /**
     *
     * Data Home Page and Query
     *
     * @return Array
     *
     **/
    public function home_data()
    {
        $courses = Course::with('course_categorie:id,name')
            ->withCount('chapters')->with('user')->latest()->where('status', 'published')
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


    /**
     *
     * Show Home Page
     *
     * @return View
     *
     **/

    public function index()
    {
        return view('frontend.index', $this->home_data());
    }


}
