<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Rack;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = Author::all();
        $genres = Genre::all();

        Book::factory()->count(10)->create()->each(function($book, $index) use($authors, $genres) {
            // Asignar entre 1 y 3 autores aleatorios a cada libro
            $book->authors()->attach($authors->random(rand(1, 3))->pluck('id')->toArray());

            // Asignar entre 1 y 4 géneros aleatorios a cada libro
            $book->genres()->attach($genres->random(rand(1, 4))->pluck('id')->toArray());

            // Poblar campos synopsis y cover_image
            $book->synopsis = 'This is a sample synopsis for book #' . ($index + 1);
            $book->cover_image = 'covers/sample_cover_' . ($index + 1) . '.jpg';
            $book->shelf_number = rand(1, 20);
            $book->call_number = 'CALL-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);

            $book->save();
        });
    }
}