<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $published = fake()->randomElement([true, false]);
        $published_at = $published ? now() : null;

        return [
            'title' => fake()->sentence(),
            'slug' => fake()->slug(),
            'excerpt' => fake()->text(200),
            'body' => fake()->text(2500),
            'image_path' => fake()->imageUrl(1280, 720),
            'published' => $published,
            'category_id' => fake()->numberBetween(1, 5),
            'user_id' => fake()->numberBetween(1, 20),
            'published_at' => $published_at,
        ];
    }
}
