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

// 4. RUTA PARA TU PANEL ACTUALIZADA CON NOTIFICACIONES Y DESCARGAS
Route::get('/panel', function () {
    $user = auth()->user();

    // 1. Historias que sigue el usuario
    $followedStories = $user->followedStories()->with('chapters')->get();

    // 2. Comentarios recibidos en las obras del autor
    // Buscamos los comentarios hechos en los capítulos que pertenecen a las historias de este usuario
    $receivedComments = collect();
    if ($user->role === 'author') {
        $receivedComments = \App\Models\Comment::with(['user', 'chapter.story'])
            ->whereHas('chapter.story', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            // Opcional: no mostrar los propios comentarios del autor
            //->where('user_id', '!=', $user->id)
            ->latest()
            ->take(5) // Mostramos los últimos 5
            ->get();
    }

    // 3. Libros digitales comprados por el usuario
    // Buscamos los pedidos completados y obtenemos sus items que sean libros digitales
    $digitalPurchases = \App\Models\OrderItem::with('book')
        ->whereHas('order', function($q) use ($user) {
            $q->where('user_id', $user->id)
              ->where('status', 'completed');
        })
        ->whereHas('book', function($q) {
            $q->where('is_digital', true);
        })
        ->latest()
        ->get();

    return view('panel', compact('followedStories', 'receivedComments', 'digitalPurchases'));
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

// Botón de Seguir Historia
Route::post('/stories/{story}/follow', [StoryController::class, 'toggleFollow'])->name('stories.follow');

// La Biblioteca de la Comunidad (Historias gratuitas)
Route::get('/comunidad', [CommunityController::class, 'index'])->name('community.index');

// Ruta para vender una historia
Route::post('/stories/{story}/sell', [BookController::class, 'publishAsBook'])->name('stories.sell');

// Comentarios
Route::post('/stories/{chapter}/comments', [CommentController::class, 'store'])->name('stories.comments.store');

require __DIR__.'/auth.php';