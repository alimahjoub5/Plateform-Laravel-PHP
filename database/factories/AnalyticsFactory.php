<?php

namespace Database\Factories;

use App\Models\Analytics;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnalyticsFactory extends Factory
{
    protected $model = Analytics::class;

    public function definition(): array
    {
        return [
            'PageVisited' => $this->faker->url(),
            'UserID' => User::factory(),
            'Action' => $this->faker->word(),
            'DeviceType' => $this->faker->randomElement(['Desktop', 'Mobile', 'Tablet']),
        ];
    }
}
