<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->search;
        $selectedGenres = $request->genres ?? [];
        $authorType = $request->author_type; // <-- NUEVO: Filtro de tipo de publicación
        $allGenres = ['Fantasía', 'Ciencia Ficción', 'Romance', 'Terror', 'Misterio', 'Aventura', 'Histórica'];

        $query = Book::where('status', 'available');

        // Filtro de texto
        if ($searchTerm) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('genre', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('user', function($uq) use ($searchTerm) {
                      $uq->where('name', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        // Filtro de casillas de Género
        if (!empty($selectedGenres)) {
            $query->whereIn('genre', $selectedGenres);
        }

        // Filtro de Origen (Editorial vs Autores Independientes)
        if ($authorType === 'editorial') {
            $query->whereNull('user_id'); // Libros sin autor de la comunidad son de la Editorial
        } elseif ($authorType === 'indie') {
            $query->whereNotNull('user_id'); // Libros con user_id vienen de la Comunidad
        }

        $books = $query->latest()->get();

        return view('shop.index', compact('books', 'searchTerm', 'selectedGenres', 'allGenres', 'authorType'));
    }

    public function show(Book $book)
    {
        return view('shop.show', compact('book'));
    }

    // Aquí mantienes tu función publishAsBook que ya tenías o cualquier otra que uses
}