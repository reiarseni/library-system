<?php
// Redireccionar a login si el usuario no está autenticado
if (!auth()->check()) {
    header('Location: ' . route('login'));
    exit;
}
?>

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-exclamation-triangle text-warning" style="font-size: 5rem;"></i>
                        <h1 class="display-4 mt-3 mb-2">¡Ha ocurrido un error!</h1>
                        <p class="lead text-muted">{{ $message ?? 'No se pudo completar la operación solicitada.' }}</p>
                    </div>
                    
                    <div class="row mt-5">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <a href="javascript:history.back()" class="btn btn-outline-primary btn-lg w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-arrow-left me-2"></i> Regresar
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-home me-2"></i> Ir al Dashboard
                            </a>
                        </div>
                    </div>
                    
                    <div class="text-center mt-5">
                        <p class="text-muted mb-0">Si el problema persiste, contacta al administrador del sistema.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
