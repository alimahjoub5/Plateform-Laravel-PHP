<?php

namespace Database\Factories;

use App\Models\ContactInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactInfoFactory extends Factory
{
    protected $model = ContactInfo::class;

    public function definition(): array
    {
        return [
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'address' => $this->faker->address(),
            'working_hours' => 'Mon-Fri: 9am - 5pm',
            'facebook_url' => $this->faker->url(),
            'twitter_url' => $this->faker->url(),
            'linkedin_url' => $this->faker->url(),
            'instagram_url' => $this->faker->url(),
        ];
    }
}
