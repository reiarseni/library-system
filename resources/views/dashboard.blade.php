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
        <div class="card shadow-sm h-100 hover-effect" id="solicitar-prestamo-card">
            <div class="card-body d-flex flex-column align-items-center justify-content-center text-center p-4">
                <div class="icon-wrapper mb-3">
                    <i class="fas fa-bookmark fa-3x text-primary"></i>
                </div>
                <h3 class="h5 mb-2">Solicitar préstamo</h3>
                <p class="text-muted">Solicita préstamos de libros de manera sencilla y rápida.</p>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm h-100 hover-effect" id="historial-prestamos-card">
            <div class="card-body d-flex flex-column align-items-center justify-content-center text-center p-4">
                <div class="icon-wrapper mb-3">
                    <i class="fas fa-history fa-3x text-primary"></i>
                </div>
                <h3 class="h5 mb-2">Mi historial de préstamos</h3>
                <p class="text-muted">Consulta tus préstamos anteriores y actuales para llevar un control de tus lecturas.</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal para solicitud de préstamos (no implementado) -->
<div class="modal fade" id="prestamoModal" tabindex="-1" aria-labelledby="prestamoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="prestamoModalLabel">
                    <i class="fas fa-info-circle me-2 text-primary"></i>Información
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="mb-4">
                    <i class="fas fa-tools fa-3x text-warning mb-3"></i>
                    <h4>Funcionalidad en desarrollo</h4>
                </div>
                <p>La funcionalidad de solicitud de préstamos no está implementada todavía. Estamos trabajando en ello y estará disponible próximamente.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para historial de préstamos (no implementado) -->
<div class="modal fade" id="historialModal" tabindex="-1" aria-labelledby="historialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="historialModalLabel">
                    <i class="fas fa-info-circle me-2 text-primary"></i>Información
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="mb-4">
                    <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                    <h4>Funcionalidad en desarrollo</h4>
                </div>
                <p>El historial de préstamos no está disponible en este momento. Pronto podrás consultar todos tus préstamos anteriores y actuales.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Manejar clic en card de solicitud de préstamo
        const prestamoCard = document.getElementById('solicitar-prestamo-card');
        if (prestamoCard) {
            prestamoCard.addEventListener('click', function() {
                const modal = new bootstrap.Modal(document.getElementById('prestamoModal'));
                modal.show();
            });
        }
        
        // Manejar clic en card de historial de préstamos
        const historialCard = document.getElementById('historial-prestamos-card');
        if (historialCard) {
            historialCard.addEventListener('click', function() {
                const modal = new bootstrap.Modal(document.getElementById('historialModal'));
                modal.show();
            });
        }
    });
</script>

@endsection
