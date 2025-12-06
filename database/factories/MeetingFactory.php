<?php

namespace Database\Factories;

use App\Models\Meeting;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MeetingFactory extends Factory
{
    protected $model = Meeting::class;

    public function definition(): array
    {
        return [
            'ProjectID' => Project::factory(),
            'OrganizerID' => User::factory(),
            'Title' => $this->faker->sentence(),
            'Description' => $this->faker->paragraph(),
            'StartTime' => $this->faker->dateTimeBetween('now', '+1 week'),
            'EndTime' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'Location' => $this->faker->address(),
        ];
    }
}
