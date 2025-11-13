<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
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
        $title = fake()->unique()->sentence(nbWords: 6);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'intro' => fake()->paragraphs(2, true),
            'body' => collect(fake()->paragraphs(6))->map(fn (string $paragraph): string => "<p>{$paragraph}</p>")->implode("\n\n"),
            'cover_path' => fake()->optional(0.5)->lexify('covers/????????.jpg'),
            'status' => Post::STATUS_DRAFT,
            'published_at' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => Post::STATUS_PUBLISHED,
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ]);
    }
}
