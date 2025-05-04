<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Book;

class BookSearch extends Component
{
    public $query = '';
    public $books = [];

    public function updatedQuery()
    {
        $this->books = Book::where('title', 'like', "%{$this->query}%")
            ->where('available_copies', '>', 0)
            ->get();
    }

    public function render()
    {
        return view('livewire.book-search', [
            'books' => $this->books,
        ]);
    }
}
