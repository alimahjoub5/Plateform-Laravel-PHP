<?php

namespace Database\Seeders;

use App\Models\Devis;
use Illuminate\Database\Seeder;

class DevisSeeder extends Seeder
{
    public function run(): void
    {
        Devis::factory()->count(10)->create();
    }
}
