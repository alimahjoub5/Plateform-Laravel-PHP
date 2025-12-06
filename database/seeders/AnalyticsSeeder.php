<?php

namespace Database\Seeders;

use App\Models\Analytics;
use Illuminate\Database\Seeder;

class AnalyticsSeeder extends Seeder
{
    public function run(): void
    {
        Analytics::factory()->count(10)->create();
    }
}
