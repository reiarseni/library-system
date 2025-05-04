@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="display-6 fw-bold mb-2"><i class="fas fa-user-shield me-2"></i>Panel de Administración</h1>
                            <p class="lead mb-0">Gestiona todos los aspectos del sistema de biblioteca</p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <div class="d-inline-flex align-items-center bg-white bg-opacity-25 rounded-pill px-3 py-2">
                                <i class="fas fa-lock me-2"></i>
                                <span>Acceso restringido</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Estadísticas -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="fas fa-users me-2"></i>Usuarios</h5>
                    <h2 class="display-4 fw-bold">{{ \App\Models\User::count() }}</h2>
                    <p class="text-muted">Usuarios registrados</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="fas fa-book me-2"></i>Libros</h5>
                    <h2 class="display-4 fw-bold">{{ \App\Models\Book::count() }}</h2>
                    <p class="text-muted">Libros en catálogo</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="fas fa-book-reader me-2"></i>Préstamos</h5>
                    <h2 class="display-4 fw-bold">{{ \App\Models\Borrow::count() }}</h2>
                    <p class="text-muted">Préstamos realizados</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="fas fa-exclamation-circle me-2"></i>Pendientes</h5>
                    <h2 class="display-4 fw-bold">{{ \App\Models\Borrow::whereNull('returned_at')->count() }}</h2>
                    <p class="text-muted">Préstamos activos</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Acciones rápidas -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2 text-primary"></i>Acciones Rápidas</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('filament.admin.resources.users.index') }}" class="btn btn-outline-primary w-100 py-3">
                                <i class="fas fa-user-plus mb-2 d-block fs-4"></i>
                                Gestionar Usuarios
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('filament.admin.resources.books.index') }}" class="btn btn-outline-primary w-100 py-3">
                                <i class="fas fa-book mb-2 d-block fs-4"></i>
                                Gestionar Libros
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('filament.admin.resources.borrows.index') }}" class="btn btn-outline-primary w-100 py-3">
                                <i class="fas fa-exchange-alt mb-2 d-block fs-4"></i>
                                Gestionar Préstamos
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('filament.admin.resources.authors.index') }}" class="btn btn-outline-primary w-100 py-3">
                                <i class="fas fa-user-edit mb-2 d-block fs-4"></i>
                                Gestionar Autores
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
