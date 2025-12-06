<?php

namespace Database\Factories;

use App\Models\TimeTracking;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimeTrackingFactory extends Factory
{
    protected $model = TimeTracking::class;

    public function definition(): array
    {
        return [
            'UserID' => User::factory(),
            'TaskID' => Task::factory(),
            'Description' => $this->faker->sentence(),
            'StartTime' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'EndTime' => $this->faker->dateTimeBetween('now', '+1 hour'),
        ];
    }
}
