<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Username' => fake()->userName(),
            'Email' => fake()->unique()->safeEmail(),
            'PasswordHash' => static::$password ??= Hash::make('password'),
            'FirstName' => fake()->firstName(),
            'LastName' => fake()->lastName(),
            'PhoneNumber' => fake()->phoneNumber(),
            'Address' => fake()->address(),
            'Role' => fake()->randomElement(['freelancer', 'Client', 'Admin']),
            'ProfilePicture' => fake()->imageUrl(),
            'Bio' => fake()->paragraph(),
            'Language' => fake()->randomElement(['English', 'Spanish', 'French', 'German']),
            'email_verified_at' => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
