<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Author;
use App\Models\Genre;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence,
            'author_id' => Author::factory(),
            'genres_id' => Genre::factory(),
            'edition' => fake()->randomNumber(),
            'year' => fake()->year,
            'pages' => fake()->randomNumber(),
            'format' => fake()->randomElement(['Capa Dura', 'E-book']),
            'license' => fake()->randomElement(['Domínio Público', 'Creative Commons']),
            'description' => fake()->paragraph,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
