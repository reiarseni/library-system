<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0"><i class="fas fa-search me-2 text-primary"></i>Búsqueda de Libros Disponibles</h5>
    </div>
    <div class="card-body">
        <div class="mb-4" wire:loading.class="opacity-50">
            <div class="row g-3 mb-3">
                <div class="col-md-6 mb-2">
                    <div class="input-group input-group-lg shadow-sm">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-book text-primary"></i></span>
                        <input type="text" class="form-control border-start-0" placeholder="Buscar libro por título..." wire:model.live.debounce.300ms="query" autocomplete="off">
                        <span class="input-group-text bg-white" wire:loading wire:target="query">
                            <i class="fas fa-spinner fa-spin text-primary"></i>
                        </span>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-user-edit text-primary"></i></span>
                        <select class="form-select border-start-0" wire:model.live="authorFilter">
                            <option value="">Todos los autores</option>
                            @foreach($authors as $author)
                                <option value="{{ $author->id }}">{{ $author->name }}</option>
                            @endforeach
                        </select>
                        <span class="input-group-text bg-white" wire:loading wire:target="authorFilter">
                            <i class="fas fa-spinner fa-spin text-primary"></i>
                        </span>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-tags text-primary"></i></span>
                        <select class="form-select border-start-0" wire:model.live="genreFilter">
                            <option value="">Todos los géneros</option>
                            @foreach($genres as $genre)
                                <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                            @endforeach
                        </select>
                        <span class="input-group-text bg-white" wire:loading wire:target="genreFilter">
                            <i class="fas fa-spinner fa-spin text-primary"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small" wire:loading.remove>
                    <i class="fas fa-info-circle me-1"></i> Filtros aplicados automáticamente
                </div>
                <div wire:loading>
                    <span class="text-primary"><i class="fas fa-spinner fa-spin me-1"></i> Buscando libros...</span>
                </div>
                <button type="button" class="btn btn-outline-secondary" wire:click="resetFilters">
                    <i class="fas fa-undo me-1"></i> Limpiar filtros
                </button>
            </div>
        </div>

        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-3"><i class="fas fa-book-open me-2 text-primary"></i>Título</th>
                        <th><i class="fas fa-user me-2 text-primary"></i>Autor</th>
                        <th><i class="fas fa-tags me-2 text-primary"></i>Género</th>
                        <th><i class="fas fa-copy me-2 text-primary"></i>Disponibles</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                        <tr>
                            <td class="ps-3 fw-medium">{{ $book->title }}</td>
                            <td>
                                @if($book->authors->count() > 0)
                                    @foreach($book->authors->take(2) as $author)
                                        <span class="badge bg-light text-dark border me-1">{{ $author->name }}</span>
                                    @endforeach
                                    @if($book->authors->count() > 2)
                                        <small class="text-muted">(+{{ $book->authors->count() - 2 }})</small>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($book->genres->count() > 0)
                                    @foreach($book->genres->take(2) as $genre)
                                        <span class="badge bg-light text-dark border me-1">{{ $genre->name }}</span>
                                    @endforeach
                                    @if($book->genres->count() > 2)
                                        <small class="text-muted">(+{{ $book->genres->count() - 2 }})</small>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $badgeClass = 'bg-success';
                                    $badgeIcon = 'fa-check-circle';
                                    
                                    if ($book->available_copies <= 0) {
                                        $badgeClass = 'bg-danger';
                                        $badgeIcon = 'fa-times-circle';
                                    } elseif ($book->available_copies == 1 && $book->copies > 1) {
                                        $badgeClass = 'bg-warning text-dark';
                                        $badgeIcon = 'fa-exclamation-circle';
                                    }
                                @endphp
                                
                                <span class="badge {{ $badgeClass }} px-3 py-2">
                                    <i class="fas {{ $badgeIcon }} me-1"></i>
                                    <strong>{{ $book->available_copies }} de {{ $book->copies }}</strong>
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No se encontraron resultados para tu búsqueda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted small">
                Mostrando {{ $books->count() }} de {{ $books->total() }} libros disponibles
            </div>
            <div>
                {{ $books->links() }}
            </div>
        </div>
    </div>
</div>
