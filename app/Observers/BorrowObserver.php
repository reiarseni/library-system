<?php

namespace App\Observers;

use App\Models\Borrow;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class BorrowObserver
{
    /**
     * Handle the Borrow "updating" event.
     * Actualizar las copias disponibles cuando se devuelve un libro
     */
    public function updating(Borrow $borrow): void
    {
        // Si el préstamo se está marcando como devuelto
        if ($borrow->isDirty('returned_at') && $borrow->returned_at !== null) {
            // Obtener todos los libros asociados a este préstamo
            foreach ($borrow->borrowBooks as $borrowBook) {
                $book = Book::find($borrowBook->book_id);
                if ($book) {
                    $book->returnCopy();
                }
            }
        }
    }
}
