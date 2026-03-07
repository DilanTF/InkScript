<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Muestra el catálogo de la tienda.
     */
    public function index()
    {
        // Obtenemos todos los libros disponibles en la tienda
        $books = Book::where('status', 'available')->get();
        
        return view('shop.index', compact('books'));
    }

    /**
     * Muestra el detalle de un libro específico.
     */
    public function show(Book $book)
    {
        return view('shop.show', compact('book'));
    }

    /**
     * Lógica para que un autor convierta su historia en un libro de venta.
     */
    public function publishAsBook(Request $request, \App\Models\Story $story)
    {
        // Validamos que el autor sea el dueño de la historia
        if (auth()->id() !== $story->user_id) {
            return back()->with('error', 'No tienes permiso para vender esta obra.');
        }

        // Creamos el registro en la tabla books (el puente)
        Book::create([
            'title' => $story->title,
            'description' => $story->description,
            'price' => $request->price,
            'genre' => $request->genre,
            'stock' => $request->stock ?? 1,
            'story_id' => $story->id,
            'user_id' => auth()->id(),
            'status' => 'available',
            'is_digital' => true, // Por defecto las historias vendidas son digitales
        ]);

        return redirect()->route('stories.index')->with('success', '¡Tu historia ya está a la venta en la tienda!');
    }
}