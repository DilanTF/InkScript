<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CommentController;

// 1. Ruta principal (Portada)
Route::get('/', function () {
    return view('welcome');
});

// 2. Rutas de Historias protegidas por Autenticación y Rol de Autor
// Usamos 'resource' para generar automáticamente las 7 rutas del CRUD
Route::resource('stories', StoryController::class)->middleware(['auth', 'role.author']);

// 3. Dashboard estándar de Laravel Breeze
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 4. Rutas del Perfil de Usuario (Generadas por Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Definimos la ruta de capítulos como un recurso dependiente de historias
Route::resource('stories.chapters', ChapterController::class)->only(['create', 'store']);

// Rutas de la Tienda
Route::get('/shop', [BookController::class, 'index'])->name('shop.index');
Route::get('/shop/book/{book}', [BookController::class, 'show'])->name('shop.show');

// Ruta para vender una historia (Solo para autores)
Route::post('/stories/{story}/sell', [BookController::class, 'publishAsBook'])->name('stories.sell');

Route::post('/stories/{story}/comments', [CommentController::class, 'store'])->name('stories.comments.store');
require __DIR__.'/auth.php';
