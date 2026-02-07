<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\CourseCategory as Category;

class ArchiveCourseController extends Controller
{
    /**
     * View All Courses Archive with Filters
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|string
     */
    public function index(Request $request)
    {
        $query = Course::query()->where('status', 'published')->withCount('chapters');

        // Search
        if ($request->filled('search')) {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        // Category
        if ($request->filled('category')) {
            $slugs = is_array($request->category) ? $request->category : [$request->category];
            $query->whereHas('course_categorie', function ($q) use ($slugs) {
                $q->whereIn('slug', $slugs);
            });
        }

        // Status (completed, performing)
        if ($request->filled('status')) {
            // Map frontend values to DB values if necessary
            // Frontend: 'completed', 'performing' (from view logic or potential inputs)
            // DB: 'completed', 'performing' (assumed based on previous view code)
            $statuses = is_array($request->status) ? $request->status : [$request->status];
            $query->whereIn('status', $statuses);
        }

        // Type (free, cash)
        if ($request->filled('type')) {
            $type = $request->type;
            if ($type == 'free') {
                $query->where(function ($q) {
                    $q->where('sale_price', 0)->orWhereNull('sale_price');
                });
            } elseif ($type == 'cash') {
                $query->where('sale_price', '>', 0);
            }
        }

        // Sort
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'newest':
                    $query->latest();
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
                case 'price_asc':
                    $query->orderBy('sale_price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('sale_price', 'desc');
                    break;
                case 'most_viewed':
                    // Assuming there is a views column, otherwise default to latest
                    // $query->orderBy('views', 'desc');
                    $query->latest();
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $courses = $query->paginate(9)->withQueryString();

        if ($request->ajax()) {
            return view('frontend.partials.ArchiveCourses.course-list', compact('courses'))->render();
        }

        $categories = Category::all();
        return view('frontend.ArchiveCourses', compact('courses', 'categories'));
    }

    public function ShowCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $courses = Course::where('category_id', $category->id)->where('status', 'published')->paginate(10);
        $categories = Category::all();
        return view('frontend.CouresCategories', compact('courses', 'categories'));
    }
}
