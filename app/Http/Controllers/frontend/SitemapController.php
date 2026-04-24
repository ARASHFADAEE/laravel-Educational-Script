<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Post;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $urls = collect([
            [
                'loc' => route('home'),
                'lastmod' => now()->toDateString(),
                'changefreq' => 'daily',
                'priority' => '1.0',
            ],
            [
                'loc' => route('about.index'),
                'lastmod' => now()->toDateString(),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ],
            [
                'loc' => route('contact.index'),
                'lastmod' => now()->toDateString(),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ],
            [
                'loc' => route('blog.index'),
                'lastmod' => now()->toDateString(),
                'changefreq' => 'daily',
                'priority' => '0.9',
            ],
            [
                'loc' => route('courses.show'),
                'lastmod' => now()->toDateString(),
                'changefreq' => 'daily',
                'priority' => '0.9',
            ],
        ])
            ->merge(
                Post::query()->where('status', 'published')->get(['slug', 'updated_at'])->map(fn ($post) => [
                    'loc' => route('single.blog.show', $post->slug),
                    'lastmod' => optional($post->updated_at)->toDateString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.8',
                ])
            )
            ->merge(
                Course::query()->where('status', 'published')->get(['slug', 'updated_at'])->map(fn ($course) => [
                    'loc' => route('course.show', $course->slug),
                    'lastmod' => optional($course->updated_at)->toDateString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.8',
                ])
            )
            ->merge(
                CourseCategory::query()->get(['slug', 'updated_at'])->map(fn ($category) => [
                    'loc' => route('show.courses.category', $category->slug),
                    'lastmod' => optional($category->updated_at)->toDateString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.6',
                ])
            );

        return response()
            ->view('frontend.sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml');
    }
}
