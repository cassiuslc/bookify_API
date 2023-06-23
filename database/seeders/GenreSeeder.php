<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Genre::create([
            'name' => 'Fiction',
            'description' => 'Books that involve imaginary events and characters.',
        ]);

        Genre::create([
            'name' => 'Mystery',
            'description' => 'Books that involve solving a crime or a puzzle.',
        ]);
    }
}
