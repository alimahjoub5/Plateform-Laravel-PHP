<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition(): array
    {
        return [
            'UserID' => User::factory(),
            'Message' => $this->faker->sentence(),
            'IsRead' => $this->faker->boolean(),
        ];
    }
}
