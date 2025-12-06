<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    protected $model = Blog::class;

    public function definition(): array
    {
        return [
            'Title' => $this->faker->sentence(),
            'Content' => $this->faker->paragraphs(3, true),
            'AuthorID' => User::factory(),
            'Category' => $this->faker->word(),
            'FeaturedImage' => $this->faker->imageUrl(),
        ];
    }
}
