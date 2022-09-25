<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nette\Utils\Random;

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
    public function definition()
    {
        return [
            'title' => fake()->sentence(mt_rand(2, 10)),
            'slug' => fake()->unique()->slug(mt_rand(2, 10), false),
            'user_id' => mt_rand(1, 10),
            'category_id' => mt_rand(1, 5),
            'body' => collect(fake()->paragraphs(mt_rand(7, 20)))->map(fn ($paragraph) => '<p>' . $paragraph . '</p>')->implode(''),
            'excerpt' => Str::limit(fake()->paragraphs(3, true), 80),
            'status' => collect(['published', 'draft', 'deleted'])->random(),
            'deleted_at' => collect([now(), null])->random(),
            'published_at' => collect([now(), null])->random(),
            'created_at_ip_address' => fake()->ipv4,
            'created_at_country' => fake()->country,
            'created_at_city' => fake()->city,
        ];
    }
}
