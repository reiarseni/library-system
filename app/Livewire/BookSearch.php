<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class BookSearch extends Component
{
    use WithPagination;

    // Usar paginación con recarga de página completa para evitar errores de JavaScript
    protected $paginationTheme = 'bootstrap';
    
    #[Url(history: true)]
    public $query = '';
    
    #[Url(history: true)]
    public $authorFilter = '';
    
    #[Url(history: true)]
    public $genreFilter = '';
    
    // Propiedades para almacenar resultados de búsqueda
    public $totalBooks = 0;
    public $searchPerformed = false;

    public function mount()
    {
        $this->searchPerformed = !empty($this->query) || !empty($this->authorFilter) || !empty($this->genreFilter);
    }

    public function resetFilters()
    {
        $this->query = '';
        $this->authorFilter = '';
        $this->genreFilter = '';
        $this->resetPage();
    }

    // Estos métodos se ejecutan automáticamente cuando cambian las propiedades
    public function updatedQuery()
    {
        $this->resetPage();
        $this->searchPerformed = true;
    }
    
    public function updatedAuthorFilter()
    {
        $this->resetPage();
        $this->searchPerformed = true;
    }
    
    public function updatedGenreFilter()
    {
        $this->resetPage();
        $this->searchPerformed = true;
    }

    public function render()
    {
        // Iniciar consulta con eager loading para evitar problema N+1
        $query = Book::with([
            'authors:id,name',  // Solo cargar los campos necesarios
            'genres:id,name'    // Solo cargar los campos necesarios
        ]);
        
        // Mostrar todos los libros, incluso los que no tienen copias disponibles
        // $query->where('copies', '>', 0);
        
        // Aplicar filtros si existen
        if (!empty($this->query)) {
            $query->where('title', 'like', "%{$this->query}%");
        }
        
        if (!empty($this->authorFilter)) {
            $query->whereHas('authors', function ($q) {
                $q->where('authors.id', $this->authorFilter);
            });
        }
        
        if (!empty($this->genreFilter)) {
            $query->whereHas('genres', function ($q) {
                $q->where('genres.id', $this->genreFilter);
            });
        }
        
        // Ordenar por fecha de creación descendente
        $query->orderByDesc('created_at');
        
        // Seleccionar solo los campos necesarios de la tabla books
        $query->select(['id', 'title', 'copies', 'available_copies', 'created_at', 'cover_image', 'synopsis']);
        
        // Ejecutar la consulta y paginar los resultados
        $books = $query->paginate(25);
        $this->totalBooks = $books->total();

        // Cargar los datos de filtros una sola vez y cachearlos
        $authors = cache()->remember('all_authors', 60*5, function () {
            return Author::orderBy('name')->get(['id', 'name']);
        });
        
        $genres = cache()->remember('all_genres', 60*5, function () {
            return Genre::orderBy('name')->get(['id', 'name']);
        });

        return view('livewire.book-search', [
            'books' => $books,
            'authors' => $authors,
            'genres' => $genres,
        ]);
    }
}
