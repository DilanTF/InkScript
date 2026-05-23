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

// 3. INICIO (Antiguo Dashboard)
// SOLUCIÓN: Buscamos los datos en la BD y los pasamos a la vista
Route::get('/inicio', function () {
    // A. Obras del mes (3 libros aleatorios que estén disponibles)
    $featuredBooks = \App\Models\Book::where('status', 'available')->inRandomOrder()->limit(3)->get();

    // B. Recomendaciones (2 libros distintos disponibles)
    $recommendedBooks = \App\Models\Book::where('status', 'available')->inRandomOrder()->limit(2)->get();

    // C. Historias gratis de OTROS autores (2 historias donde el user_id no sea el mío)
    $freeStories = \App\Models\Story::with('user')->where('user_id', '!=', auth()->id())->inRandomOrder()->limit(2)->get();

    // D. Mis historias (Todas mis obras creadas)
    $myStories = \App\Models\Story::where('user_id', auth()->id())->latest()->get();

    // Enviamos todas estas variables a la vista 'inicio'
    return view('inicio', compact('featuredBooks', 'recommendedBooks', 'freeStories', 'myStories')); 
})->middleware(['auth', 'verified'])->name('dashboard');

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
    
    // Checkout (Pasarela de Pago)
    Route::get('/checkout', [OrderController::class, 'checkoutView'])->name('checkout.index');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout.process');
});

// Definimos la ruta de capítulos como un recurso dependiente de historias
// AÑADIMOS 'show' PARA PODER LEER LOS CAPÍTULOS
Route::resource('stories.chapters', ChapterController::class)->only(['create', 'store', 'show']);

// Rutas de la Tienda
Route::get('/shop', [BookController::class, 'index'])->name('shop.index');
Route::get('/shop/book/{book}', [BookController::class, 'show'])->name('shop.show');

// Ruta para vender una historia (Solo para autores)
Route::post('/stories/{story}/sell', [BookController::class, 'publishAsBook'])->name('stories.sell');

// Comentarios
Route::post('/stories/{chapter}/comments', [CommentController::class, 'store'])->name('stories.comments.store');

require __DIR__.'/auth.php';