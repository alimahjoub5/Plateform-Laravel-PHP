<?php

namespace Database\Factories;

use App\Models\Negotiation;
use App\Models\Devis;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NegotiationFactory extends Factory
{
    protected $model = Negotiation::class;

    public function definition(): array
    {
        return [
            'devis_id' => Devis::factory(),
            'message' => $this->faker->sentence(),
            'sender_type' => $this->faker->randomElement(['client', 'freelancer']),
            'sender_id' => User::factory(),
        ];
    }
}
