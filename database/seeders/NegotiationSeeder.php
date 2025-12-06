<?php

namespace Database\Seeders;

use App\Models\Negotiation;
use Illuminate\Database\Seeder;

class NegotiationSeeder extends Seeder
{
    public function run(): void
    {
        Negotiation::factory()->count(10)->create();
    }
}
