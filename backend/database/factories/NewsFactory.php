<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(6, true),
            'text' => fake()->text(350),
            'date' => fake()->dateTimeBetween('-10 years', '-1 day'),
            // 'image_url' => fake()->randomElement([fake()->imageUrl(), null]),
            'image_url' => fake()->imageUrl(),
        ];
    }
}
