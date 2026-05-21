<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

// 1. Ruta principal (Portada) -> REDIRIGE AL LOGIN
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Rutas de Historias protegidas por Autenticación y Rol de Autor
Route::resource('stories', StoryController::class)->middleware(['auth', 'role.author']);

// 3. Dashboard estándar
Route::get('/Inicio', function () {
    return view('inicio');
})->middleware(['auth', 'verified'])->name('inicio');

// 4. Rutas del Perfil de Usuario y Carrito/Pedidos
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Carrito
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    
    // Pedidos
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
});

// Definimos la ruta de capítulos como un recurso dependiente de historias
Route::resource('stories.chapters', ChapterController::class)->only(['create', 'store']);

// Rutas de la Tienda
Route::get('/shop', [BookController::class, 'index'])->name('shop.index');
Route::get('/shop/book/{book}', [BookController::class, 'show'])->name('shop.show');

// Ruta para vender una historia (Solo para autores)
Route::post('/stories/{story}/sell', [BookController::class, 'publishAsBook'])->name('stories.sell');

Route::post('/stories/{chapter}/comments', [CommentController::class, 'store'])->name('stories.comments.store');

require __DIR__.'/auth.php';