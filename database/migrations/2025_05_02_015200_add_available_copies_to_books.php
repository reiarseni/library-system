<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Book;
use App\Models\BorrowBook;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->integer('available_copies')->default(0)->after('copies');
        });

        // Actualizar todos los libros existentes
        $books = Book::all();
        foreach ($books as $book) {
            // Contar préstamos activos
            $borrowedCount = BorrowBook::whereHas('borrow', function($query) {
                $query->whereNull('returned_at');
            })->where('book_id', $book->id)->count();
            
            // Actualizar copias disponibles
            $book->available_copies = max(0, $book->copies - $borrowedCount);
            $book->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('available_copies');
        });
    }
};
