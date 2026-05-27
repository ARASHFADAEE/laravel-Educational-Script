<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubscriptionPlan::firstOrCreate(
            ['slug' => 'monthly'],
            [
                'name' => 'ماهانه',
                'duration_days' => 30,
                'description' => 'دسترسی یکماهه به تمام دوره‌های اشتراک‌پذیر'
            ]
        );

        SubscriptionPlan::firstOrCreate(
            ['slug' => 'quarterly'],
            [
                'name' => '3 ماهه',
                'duration_days' => 90,
                'description' => 'دسترسی سه‌ماهه به تمام دوره‌های اشتراک‌پذیر'
            ]
        );
    }
}
