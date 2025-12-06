<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'Title' => $this->faker->sentence(),
            'Description' => $this->faker->paragraph(),
            'ClientID' => User::factory(),
            'Budget' => $this->faker->randomFloat(2, 500, 50000),
            'Deadline' => $this->faker->dateTimeBetween('+1 month', '+6 months'),
            'Status' => $this->faker->randomElement(['Pending', 'In Progress', 'Completed', 'Cancelled']),
            'ApprovalStatus' => $this->faker->randomElement(['Pending', 'Approved', 'Rejected']),
        ];
    }
}
