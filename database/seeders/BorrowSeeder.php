<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\BorrowBook;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BorrowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $books = Book::all();

        // Crear 20 préstamos
        for ($i = 0; $i < 10; $i++) {
            $user = $users->random();
            $borrowDate = Carbon::now()->subDays(rand(1, 60));
            $returnDate = (rand(0, 1) && $i < 15) ? $borrowDate->copy()->addDays(rand(1, 14)) : null;

            $borrow = Borrow::create([
                'user_id' => $user->id,
                'borrowed_at' => $borrowDate,
                'due_date' => $borrowDate,
                'returned_at' => $returnDate,
                //'status' => $returnDate ? 'returned' : 'borrowed',
            ]);

            // Agregar entre 1 y 3 libros a cada préstamo
            $borrowBooks = $books->random(rand(1, 3));
            foreach ($borrowBooks as $book) {
                BorrowBook::create([
                    'borrow_id' => $borrow->id,
                    'book_id' => $book->id
                ]);
            }
        }
    }
}