@extends('layouts.app')
@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 200px);">
    <div class="card login-card">
        <div class="text-center mb-4">
            <i class="fas fa-book-reader fa-3x text-primary mb-3"></i>
            <h2 class="card-title">Bienvenido</h2>
        </div>
        
        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf
            
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="nombre@ejemplo.com" required autofocus>
                <label for="email"><i class="fas fa-envelope login-icon"></i>Correo electrónico</label>
            </div>
            
            <div class="form-floating mb-4">
                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                <label for="password"><i class="fas fa-lock login-icon"></i>Contraseña</label>
            </div>
            
            @if($errors->any())
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <i class="fas fa-exclamation-circle flex-shrink-0 me-2"></i>
                    <div>{{ $errors->first() }}</div>
                </div>
            @endif
            
            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i>Ingresar
                </button>
            </div>
            
            <div class="text-center mt-4">
                <p class="text-muted">Sistema de Biblioteca - Acceso de Usuarios</p>
            </div>
        </form>
    </div>
</div>
@endsection
