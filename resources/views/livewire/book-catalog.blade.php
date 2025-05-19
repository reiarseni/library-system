<div>
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-book-open me-2 text-primary"></i>Catálogo de Libros</h5>
        </div>
        <div class="card-body bg-light py-4">
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
                @forelse($books as $book)
                    <div class="col mb-3">
                        <div class="card h-100 library-book-card position-relative">
                            <!-- Imagen de portada -->
                            <div class="book-cover-container">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/covers/' . basename($book->cover_image)) }}" 
                                         alt="Portada de {{ $book->title }}" 
                                         class="book-cover">
                                @else
                                    <img src="{{ asset('images/default_cover.png') }}" 
                                         alt="Portada no disponible" 
                                         class="book-cover default-cover">
                                @endif
                                
                                <!-- Indicador de disponibilidad -->
                                <div class="availability-badge {{ $book->available_copies > 0 ? 'available' : 'unavailable' }}">
                                    <span>{{ $book->available_copies > 0 ? $book->available_copies : 'No disponible' }}</span>
                                </div>
                            </div>
                            
                            <!-- Información del libro -->
                            <div class="card-body p-3">
                                <h6 class="book-title" title="{{ $book->title }}">{{ $book->title }}</h6>
                                
                                @if($book->authors->count() > 0)
                                <div class="book-author">
                                    <i class="fas fa-user-edit me-1 text-muted"></i>
                                    {{ $book->authors->first()->name }}
                                    @if($book->authors->count() > 1)
                                        <small class="text-muted">(+{{ $book->authors->count() - 1 }})</small>
                                    @endif
                                </div>
                                @endif
                                
                                <!-- Géneros -->
                                <div class="book-genres mt-2">
                                    @foreach($book->genres->take(2) as $genre)
                                        <span class="book-genre">{{ $genre->name }}</span>
                                    @endforeach
                                    @if($book->genres->count() > 2)
                                        <span class="book-genre-more">+{{ $book->genres->count() - 2 }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Overlay de sinopsis al hacer hover -->
                            @if($book->synopsis)
                            <div class="book-synopsis-overlay">
                                <div class="synopsis-content">
                                    <h6 class="synopsis-title">Sinopsis</h6>
                                    <div class="synopsis-text">{{ $book->synopsis }}</div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="text-muted">
                            <i class="fas fa-books fa-3x mb-3"></i>
                            <p>No se encontraron libros en el catálogo.</p>
                        </div>
                    </div>
                @endforelse
            </div>
            
            <!-- Paginación -->
            <div class="d-flex justify-content-between align-items-center mt-5">
                <div class="text-muted small">
                    Mostrando {{ $books->count() }} de {{ $books->total() }} libros en catálogo
                </div>
                <div class="w-100">
                    {{ $books->links() }}
                </div>
            </div>
        </div>
    </div>
    
    <style>
        /* Estilos modernos para cards de libros */
        .library-book-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
        }
        
        .library-book-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 20px rgba(0,0,0,0.12);
        }
        
        /* Contenedor de imagen con proporción fija */
        .book-cover-container {
            position: relative;
            height: 220px;
            background: #f0f0f0;
            overflow: hidden;
        }
        
        /* Imagen de portada */
        .book-cover {
            width: 100%;
            height: 100%;
            object-fit: contain; /* Muestra la imagen completa sin recortar */
            padding: 0;
            transition: transform 0.5s ease;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }
        
        .default-cover {
            padding: 10%;
            object-fit: contain;
        }
        
        /* Badge de disponibilidad */
        .availability-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .availability-badge.available {
            background-color: #38c172;
        }
        
        .availability-badge.unavailable {
            background-color: #e3342f;
        }
        
        /* Título del libro */
        .book-title {
            font-size: 0.95rem;
            font-weight: 600;
            line-height: 1.3;
            margin-bottom: 6px;
            color: #2d3748;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 2.6rem;
        }
        
        /* Autor */
        .book-author {
            font-size: 0.85rem;
            color: #718096;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 5px;
        }
        
        /* Géneros */
        .book-genres {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }
        
        .book-genre {
            font-size: 0.7rem;
            background-color: #edf2f7;
            color: #4a5568;
            padding: 2px 8px;
            border-radius: 12px;
            display: inline-block;
        }
        
        .book-genre-more {
            font-size: 0.7rem;
            background-color: #cbd5e0;
            color: #4a5568;
            padding: 2px 8px;
            border-radius: 12px;
            display: inline-block;
        }
        
        /* Overlay de sinopsis */
        .book-synopsis-overlay {
            position: absolute;
            inset: 0;
            background: rgba(15,15,15,0.92);
            color: #fff;
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s ease;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
        }
        .book-card:hover .book-synopsis-overlay {
            opacity: 1;
            pointer-events: auto;
        }
        .synopsis-text {
            max-height: 140px;
            overflow-y: auto;
        }
    </style>
</div>
