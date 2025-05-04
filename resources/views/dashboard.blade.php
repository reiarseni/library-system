@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="card bg-primary text-white shadow-sm">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="display-6 fw-bold mb-2"><i class="fas fa-book-reader me-2"></i>Biblioteca Digital</h1>
                        <p class="lead mb-0">Explora nuestra colección de libros disponibles para préstamo</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <div class="d-inline-flex align-items-center bg-white bg-opacity-25 rounded-pill px-3 py-2">
                            <i class="fas fa-info-circle me-2"></i>
                            <span>Catálogo de libros</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4 mb-4 mb-md-0">
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex flex-column align-items-center justify-content-center text-center p-4">
                <div class="icon-wrapper mb-3">
                    <i class="fas fa-search fa-3x text-primary"></i>
                </div>
                <h3 class="h5 mb-2">Búsqueda Avanzada</h3>
                <p class="text-muted">Encuentra fácilmente el libro que estás buscando con nuestros filtros avanzados.</p>

            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4 mb-md-0">
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex flex-column align-items-center justify-content-center text-center p-4">
                <div class="icon-wrapper mb-3">
                    <i class="fas fa-book fa-3x text-primary"></i>
                </div>
                <h3 class="h5 mb-2">Catálogo Completo</h3>
                <p class="text-muted">Accede a nuestro extenso catálogo de libros de diferentes géneros y autores.</p>
            </div>
        </div>
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
