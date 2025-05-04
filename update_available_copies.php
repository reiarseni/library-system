<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Book;
use App\Models\BorrowBook;

// Actualizar todos los libros existentes
$books = Book::all();
echo "Actualizando copias disponibles para " . count($books) . " libros...\n";

foreach ($books as $book) {
    // Contar préstamos activos
    $borrowedCount = BorrowBook::whereHas('borrow', function($query) {
        $query->whereNull('returned_at');
    })->where('book_id', $book->id)->count();
    
    // Actualizar copias disponibles
    $book->available_copies = max(0, $book->copies - $borrowedCount);
    $book->save();
    
    echo "Libro ID {$book->id}: {$book->title} - Copias: {$book->copies}, Disponibles: {$book->available_copies}\n";
}

echo "¡Actualización completada!\n";
