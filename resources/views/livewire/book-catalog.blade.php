<div>
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-book-open me-2 text-primary"></i>Catálogo de Libros</h5>
        </div>
        <div class="card-body bg-light py-4">
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
                @forelse($books as $book)
                    <div class="col mb-3">
                        <div class="card h-100 library-book-card position-relative" onclick="mostrarSinopsis({{ $book->id }}, '{{ addslashes($book->title) }}', '{{ addslashes($book->synopsis) }}', '{{ $book->cover_image ? asset('storage/covers/' . basename($book->cover_image)) : asset('images/default_cover.png') }}', {{ $book->available_copies }}, '{{ $book->authors->pluck('name')->join('|') }}', '{{ $book->genres->pluck('name')->join('|') }}')">
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
                <div class="w-100 pagination-circle">
                    {{ $books->onEachSide(1)->links('vendor.pagination.bootstrap-5') }}
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
        /* Estilo para indicar que la tarjeta es clickeable */
        .library-book-card {
            cursor: pointer;
        }
        .synopsis-text {
            max-height: 140px;
            overflow-y: auto;
        }

        /* Estilos para el modal de detalles del libro */
        .book-modal-cover {
            max-height: 300px;
            object-fit: contain;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 10px;
            border: 1px solid #dee2e6;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .book-modal-cover:hover {
            transform: scale(1.02);
        }

        .book-synopsis-content {
            line-height: 1.6;
            text-align: justify;
            max-height: 300px;
            overflow-y: auto;
            padding: 10px;
            border-radius: 4px;
            background-color: #f9f9f9;
        }
        
        /* Estilo para la imagen en el modal */
        .book-modal-cover {
            max-height: 300px;
            object-fit: contain;
        }
        
        /* Estilo para el contenido de la sinopsis */
        .book-synopsis-content {
            max-height: 300px;
            overflow-y: auto;
        }
    </style>

    <!-- Modal global para mostrar los detalles del libro -->
    <div class="modal fade" id="modalDetallesLibro" tabindex="-1" aria-labelledby="modalDetallesLibroLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetallesLibroLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <!-- Autores -->
                        <div class="col-12 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-edit me-2 text-primary"></i>
                                <h6 class="mb-0 me-2">Autores:</h6>
                                <div id="modal-autores" class="fst-italic"></div>
                            </div>
                        </div>
                        
                        <!-- Géneros -->
                        <div class="col-12 mb-4">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-tags me-2 text-primary mt-1"></i>
                                <h6 class="mb-0 me-2 mt-1">Géneros:</h6>
                                <div id="modal-generos" class="d-flex flex-wrap"></div>
                            </div>
                        </div>
                        
                        <!-- Imagen de portada -->
                        <div class="col-md-4 mb-3 text-center">
                            <img id="modal-imagen" class="img-fluid rounded book-modal-cover" alt="Portada del libro">
                            <div class="mt-2">
                                <span id="modal-disponibilidad" class="badge rounded-pill"></span>
                            </div>
                        </div>
                        
                        <!-- Sinopsis -->
                        <div class="col-md-8 mb-3">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-book-open me-2 text-primary"></i>Sinopsis</h6>
                                </div>
                                <div class="card-body">
                                    <div id="modal-sinopsis" class="book-synopsis-content"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Función para mostrar la sinopsis del libro en el modal
        function mostrarSinopsis(id, titulo, sinopsis, imagen, copias, autores, generos) {
            // Setear el título
            document.getElementById('modalDetallesLibroLabel').textContent = titulo;
            
            // Setear la sinopsis
            const sinopsisElement = document.getElementById('modal-sinopsis');
            if (sinopsis) {
                sinopsisElement.textContent = sinopsis;
            } else {
                sinopsisElement.innerHTML = '<em>No hay sinopsis disponible para este libro.</em>';
            }
            
            // Setear la imagen
            document.getElementById('modal-imagen').src = imagen;
            
            // Setear la disponibilidad
            const disponibilidadElement = document.getElementById('modal-disponibilidad');
            if (copias > 0) {
                disponibilidadElement.className = 'badge rounded-pill bg-success';
                disponibilidadElement.textContent = copias + ' copias disponibles';
            } else {
                disponibilidadElement.className = 'badge rounded-pill bg-danger';
                disponibilidadElement.textContent = 'No disponible';
            }
            
            // Setear los autores
            const autoresElement = document.getElementById('modal-autores');
            if (autores) {
                autoresElement.textContent = autores.split('|').join(', ');
            } else {
                autoresElement.textContent = 'Autor desconocido';
            }
            
            // Setear los géneros
            const generosElement = document.getElementById('modal-generos');
            generosElement.innerHTML = '';
            
            if (generos) {
                const generosArray = generos.split('|');
                generosArray.forEach(genero => {
                    if (genero.trim() !== '') {
                        const span = document.createElement('span');
                        span.className = 'badge bg-light text-dark me-1 mb-1';
                        span.textContent = genero;
                        generosElement.appendChild(span);
                    }
                });
            }
            
            // Mostrar el modal usando Bootstrap
            const modal = new bootstrap.Modal(document.getElementById('modalDetallesLibro'));
            modal.show();
        }
    </script>
</div>
