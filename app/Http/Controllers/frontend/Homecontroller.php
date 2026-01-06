<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\course;
use App\Models\Post;

class Homecontroller extends Controller
{

    public function home_data(){
$courses = Course::with('course_categorie:id,name')
                 ->withCount('lessons')
                 ->paginate(3);

        $posts=Post::with('post_categorie:id,name')->paginate(4);
        return[
            'courses'=>$courses,
            'posts'=>$posts
        ];
    }
    
    public function index(){

  
        return view('frontend.index',$this->home_data());
    }
}
