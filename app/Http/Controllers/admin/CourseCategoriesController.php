<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\course_categorie as CourseCategory;

class CourseCategoriesController extends Controller
{

    /**
     * Course Category Lists
     * @return  view
     **/
    public function index()
    {
        $courseCategories = CourseCategory::all()->sortBy('name');
        return view('admin.CourseCategories.index', compact('courseCategories'));
    }




    /**
     *
     * Course Category Show Create Page
     *
     * @return view
     *
     **/
    public function create()
    {
        return view('admin.CourseCategories.create');
    }



    /**
     *
     * Course Category Store Data
     *
     * @return Store
     *
     **/
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:course_categories,slug',
        ]);

        CourseCategory::create([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        return redirect()->route('admin.course_categories.index')->with('success', 'ذخیره دسته بندی با موفقیت انجام شد');
    }




    /**
     *
     * Course Category Show Edit Page
     *
     * @return view
     *
     **/

    public function edit($id)
    {
        $category = CourseCategory::findOrFail($id);
        return view('admin.CourseCategories.edit', compact('category'));
    }



    /**
     *
     * Course Category Update
     *
     * @return update
     *
     **/

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:course_categories,slug,' . $id,
        ]);

        $category = CourseCategory::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        return redirect()->route('admin.course_categories.index')->with('success', 'آپدیت دسته بندی با موفقیت انجام شد');
    }



    /**
     *
     * Course Category destroy
     *
     * @return update
     *
     **/


    public function destroy($id)
    {
        $category = CourseCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.course_categories.index')->with('success', 'حذف دسته بندی با موفقیت انجام شد');
    }
}
