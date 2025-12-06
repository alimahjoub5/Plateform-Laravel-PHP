<?php

namespace Database\Factories;

use App\Models\Portfolio;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class PortfolioFactory extends Factory
{
    protected $model = Portfolio::class;

    public function definition(): array
    {
        return [
            'ProjectID' => Project::factory(),
            'Title' => $this->faker->sentence(),
            'Description' => $this->faker->paragraph(),
            'ImageURL' => $this->faker->imageUrl(),
            'LiveLink' => $this->faker->url(),
            'Category' => $this->faker->word(),
            'Tags' => $this->faker->words(3, true),
        ];
    }
}
