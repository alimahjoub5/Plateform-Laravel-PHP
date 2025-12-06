<?php

namespace Database\Factories;

use App\Models\Testimonial;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonialFactory extends Factory
{
    protected $model = Testimonial::class;

    public function definition(): array
    {
        return [
            'ClientID' => User::factory(),
            'ProjectID' => Project::factory(),
            'Content' => $this->faker->paragraph(),
            'Rating' => $this->faker->numberBetween(1, 5),
            'Status' => $this->faker->randomElement(['Pending', 'Approved', 'Rejected']),
            'AdminComment' => $this->faker->optional()->sentence(),
        ];
    }
}
