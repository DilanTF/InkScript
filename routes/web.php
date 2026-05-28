<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CommunityController;

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
    $user = auth()->user();

    // 1. Historias que sigue el usuario
    $followedStories = $user->followedStories()->with('chapters')->get();

    // 2. Comentarios recibidos
    $receivedComments = collect();
    if ($user->role === 'author') {
        $receivedComments = \App\Models\Comment::with(['user', 'chapter.story'])
            ->whereHas('chapter.story', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->latest()
            ->take(5)
            ->get();
    }

    // 3. Libros digitales comprados (SOLUCIÓN AL BUG: whereIn con 'completado' y 'completed')
    $digitalPurchases = \App\Models\OrderItem::with('book')
        ->whereHas('order', function($q) use ($user) {
            $q->where('user_id', $user->id)
              ->whereIn('status', ['completed', 'completado']); // <-- CORREGIDO AQUÍ
        })
        ->whereHas('book', function($q) {
            $q->where('is_digital', true);
        })
        ->latest()
        ->get()
        ->unique('book_id')
        ->take(5);

    return view('panel', compact('followedStories', 'receivedComments', 'digitalPurchases'));
})->middleware(['auth', 'verified'])->name('panel');

// 5. NUEVA RUTA: INVENTARIO DIGITAL
Route::get('/inventario', function () {
    $user = auth()->user();
    
    // Todos los libros digitales comprados (SOLUCIÓN AL BUG)
    $inventory = \App\Models\OrderItem::with('book')
        ->whereHas('order', function($q) use ($user) {
            $q->where('user_id', $user->id)
              ->whereIn('status', ['completed', 'completado']); // <-- CORREGIDO AQUÍ
        })
        ->whereHas('book', function($q) {
            $q->where('is_digital', true);
        })
        ->latest()
        ->get()
        ->unique('book_id');

    return view('inventory.index', compact('inventory'));
})->middleware(['auth', 'verified'])->name('inventory.index');


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
    
    // Checkout
    Route::get('/checkout', [OrderController::class, 'checkoutView'])->name('checkout.index');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout.process');
});

// AHORA PERMITIMOS TODAS LAS RUTAS DE CAPÍTULOS (Incluida la edición)
Route::resource('stories.chapters', ChapterController::class);

// Rutas de la Tienda (Libros de pago)
Route::get('/shop', [BookController::class, 'index'])->name('shop.index');
Route::get('/shop/book/{book}', [BookController::class, 'show'])->name('shop.show');

// Botón de Seguir Historia
Route::post('/stories/{story}/follow', [StoryController::class, 'toggleFollow'])->name('stories.follow');

// La Biblioteca de la Comunidad
Route::get('/comunidad', [CommunityController::class, 'index'])->name('community.index');

// Ruta para vender una historia
Route::post('/stories/{story}/sell', [BookController::class, 'publishAsBook'])->name('stories.sell');

// Ruta para monetizar un volumen entero masivamente
Route::post('/stories/{story}/monetize-volume', [StoryController::class, 'monetizeVolume'])->name('stories.monetize');

// Comentarios
Route::post('/stories/{chapter}/comments', [CommentController::class, 'store'])->name('stories.comments.store');

require __DIR__.'/auth.php';