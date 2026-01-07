<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\post_categorie as category;

class PostCategoryController extends Controller
{


    public function index(){

         $categories_blog=category::paginate(15);
        return view('admin.postcategories.index',compact('categories_blog'));
    }
    


    public function create(){
        return view('admin.postcategories.create');
    }





    public function store(Request $request){

        $data=$request->validate([
            "name"=>'required|min:4',
            "slug"=>'required|unique:post_categories'
        ],[
            'name:required'=>'نام دسته بندی الزامی هست.',
            'slug:required'=> 'اسلاگ دسته بندی الزامی هست',
            'name:min:4'=>'حداقل کاراکتر باید ۴ کاراکتر باشید',
            'unique:post_categories'=>'این اسلاگ قبلا استفاده شده'
        ]);

        category::create($data);

        return redirect(route('admin.post.categories.index'))->with('success','دسته بندی با موفقیت ایجاد شد');





    }

    public function edit($id){
        $category=category::query()->findOrFail($id);

        return view('admin.postcategories.edit', compact('category'));
    }

    public function update(Request $request ,$id){
        $category=category::query()->findOrFail($id);

        $data=$request->validate([
            'name'=>'required|string|min:3',
            'slug'=>'required|string|min:3'
        ]);

        $category->update($data);

        return redirect()->route("admin.post.categories.index")->with('success','آپدیت با موفقیت انجام شد');
    }

    public function destroy($id){

        $category_post=category::query()->findOrFail($id);

        $category_post->delete();


        return redirect()->route('admin.post.categories.index')->with('success','دسته بندی با موفقیت حذف شد ');


    }
}
