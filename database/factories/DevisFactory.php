<?php

namespace Database\Factories;

use App\Models\Devis;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DevisFactory extends Factory
{
    protected $model = Devis::class;

    public function definition(): array
    {
        return [
            'ProjectID' => Project::factory(),
            'ClientID' => User::factory(),
            'Reference' => $this->faker->unique()->bothify('DEV-####'),
            'DateEmission' => $this->faker->date(),
            'DateValidite' => $this->faker->date(),
            'TotalHT' => $this->faker->randomFloat(2, 100, 10000),
            'TVA' => $this->faker->randomFloat(2, 20, 2000),
            'TotalTTC' => $this->faker->randomFloat(2, 120, 12000),
            'Statut' => $this->faker->randomElement(['Draft', 'Sent', 'Accepted', 'Rejected']),
            'ConditionsGenerales' => $this->faker->paragraph(),
            'signature' => $this->faker->optional()->word(),
        ];
    }
}
