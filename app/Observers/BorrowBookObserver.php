<?php

namespace App\Observers;

use App\Models\BorrowBook;
use App\Models\Book;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BorrowBookObserver
{
    /**
     * Handle the BorrowBook "creating" event.
     * Validar que no se presten libros si no hay copias disponibles
     */
    public function creating(BorrowBook $borrowBook): void
    {
        $book = Book::findOrFail($borrowBook->book_id);
        
        if ($book->available_copies <= 0) {
            throw ValidationException::withMessages([
                'book_id' => "No hay copias disponibles del libro '{$book->title}'",
            ]);
        }
    }

    /**
     * Handle the BorrowBook "created" event.
     * Actualizar el contador de copias disponibles
     */
    public function created(BorrowBook $borrowBook): void
    {
        $book = Book::findOrFail($borrowBook->book_id);
        $book->borrowCopy();
    }

    /**
     * Handle the BorrowBook "deleted" event.
     * Actualizar el contador de copias disponibles cuando se elimina un préstamo
     */
    public function deleted(BorrowBook $borrowBook): void
    {
        $book = Book::findOrFail($borrowBook->book_id);
        $book->returnCopy();
    }
}
