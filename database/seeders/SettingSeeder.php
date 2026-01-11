<?php

namespace Database\Seeders;
use App\Models\Setting;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $settings = [
            [
                'key' => 'site_name',
                'value' => env('APP_NAME'),
            ],
            [
                'key' => 'site_email',
                'value' => "info@fadaee.dev",
            ],
            [
                'key' => 'site_phone',
                'value' => "09140065379",
            ],
            [
                'key' => 'site_address',
                'value'=>'https://fadaee.dev',
            ],
            [
                'key' => 'site_logo',
                'value' => null,
            ],
            [
                'key' => 'site_favicon',
                'value' => null,
            ],
            [
                'key' => 'site_copyright',
                'value' => null,
            ],
            [
                'key' => 'Title_Home_Page',
                'value' => null,
            ],
            [
                'key' => 'Title_About_Page',
                'value' => null,
            ],
            [
                'key' => 'Title_Contact_Page',
                'value' => null,
            ],
            [
                'key'=>'robots',
                'value'=>'follow, index',
            ],
            [
                'key'=>'Time_Work_footer',
                'value'=>"۰۹:۰۰ - ۱۷:۰۰",
            ]
        ];

        foreach ($settings as $setting) {

            Setting::create([
                'key' => $setting['key'],
                'value' => $setting['value'],
            ]);



        }



    }
}
