@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="card bg-primary text-white shadow-sm">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <h2 class=" fw-bold mb-2"><i class="fas fa-book-reader me-2"></i>Biblioteca Houston Comunity Investment</h2>
                        <p class="lead mb-0">Explora nuestra colección de libros disponibles para préstamo</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4 mb-4 mb-md-0">
        <a href="{{ route('books.search') }}" class="text-decoration-none">
            <div class="card shadow-sm h-100 hover-effect">
                <div class="card-body d-flex flex-column align-items-center justify-content-center text-center p-4">
                    <div class="icon-wrapper mb-3">
                        <i class="fas fa-search fa-3x text-primary"></i>
                    </div>
                    <h3 class="h5 mb-2">Búsqueda Avanzada</h3>
                    <p class="text-muted">Encuentra fácilmente el libro que estás buscando con nuestros filtros avanzados.</p>
                </div>
            </div>
        </a>
    </div>
    <style>
        .hover-effect {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .hover-effect:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
        }
        .card {
            cursor: pointer;
        }
    </style>
    <div class="col-md-4 mb-4 mb-md-0">
        <a href="{{ route('books.catalog') }}" class="text-decoration-none">
            <div class="card shadow-sm h-100 hover-effect">
                <div class="card-body d-flex flex-column align-items-center justify-content-center text-center p-4">
                    <div class="icon-wrapper mb-3">
                        <i class="fas fa-book-open fa-3x text-primary"></i>
                    </div>
                    <h3 class="h5 mb-2">Catálogo Completo</h3>
                    <p class="text-muted">Explora nuestra colección completa de libros disponibles en la biblioteca.</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex flex-column align-items-center justify-content-center text-center p-4">
                <div class="icon-wrapper mb-3">
                    <i class="fas fa-bookmark fa-3x text-primary"></i>
                </div>
                <h3 class="h5 mb-2">Préstamos Fáciles</h3>
                <p class="text-muted">Solicita préstamos de libros de manera sencilla y rápida.</p>
            </div>
        </div>
    </div>
</div>
@endsection
