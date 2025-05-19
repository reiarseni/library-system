<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Book;
use App\Models\Genre;
use Livewire\WithPagination;

class BookCatalog extends Component
{
    use WithPagination;
    
    // Usar paginación con recarga de página completa para evitar errores de JavaScript
    protected $paginationTheme = 'bootstrap';
    
    public function render()
    {
        // Consulta con eager loading para evitar problema N+1
        $books = Book::with([
            'authors:id,name',
            'genres:id,name',
            'rack:id' // Solo id, elimina location
        ])
        ->select(['id', 'title', 'copies', 'available_copies', 'created_at', 'rack_id', 'cover_image', 'synopsis'])
        ->orderByDesc('created_at')
        ->paginate(24); // Mostrar más libros por página para el catálogo
        
        return view('livewire.book-catalog', [
            'books' => $books,
        ]);
    }
}
