<?php

namespace Database\Seeders;

use App\Models\TimeTracking;
use Illuminate\Database\Seeder;

class TimeTrackingSeeder extends Seeder
{
    public function run(): void
    {
        TimeTracking::factory()->count(10)->create();
    }
}
