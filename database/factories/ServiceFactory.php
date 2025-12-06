<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        return [
            'ServiceName' => $this->faker->words(3, true),
            'Description' => $this->faker->paragraph(),
            'Price' => $this->faker->randomFloat(2, 50, 1000),
            'Category' => $this->faker->word(),
            'IsAvailable' => $this->faker->boolean(80),
        ];
    }
}
