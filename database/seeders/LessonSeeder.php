<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lesson;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        for ($i = 84; $i < 95; $i++) {

            if ($i<19) {
                Lesson::create([
                    'title' => "درس $i",
                    "chapter_id" => 10,
                    "slug" => "lesson-$i",
                    "content" => "درس $i",
                    "video_url" => "http://localhost:8888/uploader/06/js-0$i.mp4"
                ]);
            }else{
                Lesson::create([
                    'title' => "درس $i",
                    "chapter_id" => 10,
                    "slug" => "lesson-$i",
                    "content" => "درس $i",
                    "video_url" => "http://localhost:8888/uploader/06/js-$i.mp4"
                ]);


            }

        }

    }
}
