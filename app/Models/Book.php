<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'copies',
        'available_copies',
        'isbn',
        'synopsis',
        'cover_image',
        'rack_id',
        'shelf_number',
        'call_number',
    ];

    /**
     * Determina si el libro está disponible para préstamo
     */
    public function isAvailable()
    {
        return $this->available_copies > 0;
    }

    /**
     * Accesor para obtener las copias disponibles en tiempo real
     */
    public function getAvailableCopiesAttribute()
    {
        // Si el campo 'copies' no está definido, retorna 0
        $total = $this->copies ?? 0;
        // Préstamos activos = no devueltos
        $activeBorrows = $this->borrows()->whereNull('returned_at')->count();
        return $total - $activeBorrows;
    }

    /**
     * Actualiza las copias disponibles cuando se presta un libro
     */
    public function borrowCopy()
    {
        if ($this->available_copies <= 0) {
            throw new \Exception('No hay copias disponibles de este libro');
        }

        $this->available_copies -= 1;
        $this->save();

        return $this;
    }

    /**
     * Actualiza las copias disponibles cuando se devuelve un libro
     */
    public function returnCopy()
    {
        if ($this->available_copies < $this->copies) {
            $this->available_copies += 1;
            $this->save();
        }

        return $this;
    }


    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function rack()
    {
        return $this->belongsTo(Rack::class);
    }

    /**
     * Relación con los préstamos a través de la tabla pivote
     */
    public function borrows()
    {
        return $this->belongsToMany(Borrow::class, 'borrow_book')
            ->withTimestamps();
    }

    /**
     * Relación con los préstamos activos (no devueltos)
     */
    public function activeBorrows()
    {
        return $this->belongsToMany(Borrow::class, 'borrow_book')
            ->whereNull('returned_at')
            ->withTimestamps();
    }
}
