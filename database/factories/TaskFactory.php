<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'Title' => $this->faker->sentence(),
            'Description' => $this->faker->paragraph(),
            'ProjectID' => Project::factory(),
            'AssignedTo' => User::factory(),
            'Status' => $this->faker->randomElement(['To Do', 'In Progress', 'Done']),
            'Priority' => $this->faker->randomElement(['Low', 'Medium', 'High']),
            'StartDate' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'DueDate' => $this->faker->dateTimeBetween('now', '+1 month'),
            'EstimatedHours' => $this->faker->numberBetween(1, 100),
            'ActualHours' => $this->faker->numberBetween(0, 100),
            'CompletionPercentage' => $this->faker->numberBetween(0, 100),
        ];
    }
}
