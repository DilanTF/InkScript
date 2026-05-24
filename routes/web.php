<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CommunityController; // AÑADIDO: Importamos el controlador de la comunidad

// 1. Ruta principal (Portada) -> REDIRIGE AL LOGIN
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Rutas de Historias protegidas por Autenticación y Rol de Autor
Route::resource('stories', StoryController::class)->middleware(['auth', 'role.author']);

// 3. INICIO (Dashboard principal)
Route::get('/dashboard', function () {
    $featuredBooks = \App\Models\Book::where('status', 'available')->inRandomOrder()->limit(3)->get();
    $recommendedBooks = \App\Models\Book::where('status', 'available')->inRandomOrder()->limit(2)->get();
    $freeStories = \App\Models\Story::with('user')->where('user_id', '!=', auth()->id())->inRandomOrder()->limit(2)->get();
    $myStories = \App\Models\Story::where('user_id', auth()->id())->latest()->get();

    return view('inicio', compact('featuredBooks', 'recommendedBooks', 'freeStories', 'myStories'));
})->middleware(['auth', 'verified'])->name('dashboard');

// 4. RUTA PARA TU PANEL
Route::get('/panel', function () {
    return view('panel');
})->middleware(['auth', 'verified'])->name('panel');

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
    
    // Checkout (Pasarela de Pago)
    Route::get('/checkout', [OrderController::class, 'checkoutView'])->name('checkout.index');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout.process');
});

Route::resource('stories.chapters', ChapterController::class)->only(['create', 'store', 'show']);

// Rutas de la Tienda (Libros de pago)
Route::get('/shop', [BookController::class, 'index'])->name('shop.index');
Route::get('/shop/book/{book}', [BookController::class, 'show'])->name('shop.show');

// Ruta de la Biblioteca de la Comunidad (Historias gratuitas)
Route::get('/comunidad', [CommunityController::class, 'index'])->name('community.index');

// Ruta para vender una historia
Route::post('/stories/{story}/sell', [BookController::class, 'publishAsBook'])->name('stories.sell');

// Comentarios
Route::post('/stories/{chapter}/comments', [CommentController::class, 'store'])->name('stories.comments.store');

require __DIR__.'/auth.php';