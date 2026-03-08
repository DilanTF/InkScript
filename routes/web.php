<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

// 1. Público (Sin login)
Route::get('/', function () { return view('welcome'); });

// Tienda (Lectura y compra)
Route::get('/shop', [BookController::class, 'index'])->name('shop.index');
Route::get('/shop/book/{book}', [BookController::class, 'show'])->name('shop.show');

// 2. Usuarios Autenticados
Route::middleware('auth')->group(function () {
    
    // Perfil y Dashboard
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Carrito y Pedidos
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::post('/remove', [CartController::class, 'remove'])->name('remove');
        Route::post('/clear', [CartController::class, 'clear'])->name('clear');
        Route::post('/update', [CartController::class, 'update'])->name('update');
    });
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');

    // COMENTARIOS: Vinculados a un capítulo
    Route::post('/chapters/{chapter}/comments', [CommentController::class, 'store'])->name('comments.store');
});

// 3. Autores (Gestión de contenido)
Route::middleware(['auth', 'role.author'])->group(function () {
    Route::resource('stories', StoryController::class);
    Route::resource('stories.chapters', ChapterController::class)->only(['create', 'store', 'show']);
    Route::post('/stories/{story}/sell', [BookController::class, 'publishAsBook'])->name('stories.sell');
    Route::get('/my-stats', [StoryController::class, 'stats'])->name('stories.stats')->middleware('role.author');
});

require __DIR__.'/auth.php';