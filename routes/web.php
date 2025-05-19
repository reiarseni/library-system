<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rutas de autenticación
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Redirección de la raíz a login o dashboard según autenticación
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    // Dashboard en la ruta principal para usuarios autenticados
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    // Búsqueda de libros
    Route::get('/search', function () {
        return view('books.search');
    })->name('books.search');
    
    // Catálogo de libros
    Route::get('/catalog', function () {
        return view('books.catalog');
    })->name('books.catalog');
});
