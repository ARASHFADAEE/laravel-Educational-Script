<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\post_categorie;
use App\Models\course_categorie;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create(
            [
                "name"=>"آرش فدایی",
                "email"=>"hosseinfdnews@gmail.com",
                "role"=>"admin",
                "avatar"=>"null",
                "password"=>Hash::make('123456789')
            ]
        );


        post_categorie::create([
            "name"=>"دسته بندی تستی",
            "slug"=>"test-category"
        ]);

        course_categorie::create([
            "name"=>"دسته بندی دوره",
            "slug"=>"course-category"
        ]);







    }
}
