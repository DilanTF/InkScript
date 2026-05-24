<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->search;
        $selectedGenres = $request->genres ?? []; // Array con las casillas marcadas
        $allGenres = ['Fantasía', 'Ciencia Ficción', 'Romance', 'Terror', 'Misterio', 'Aventura', 'Histórica'];

        // Solo cargamos historias que tengan al menos 1 capítulo publicado
        $query = Story::with('user')->has('chapters');

        // Filtro 1: Buscador de texto
        if ($searchTerm) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('user', function($uq) use ($searchTerm) {
                      $uq->where('name', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        // Filtro 2: Casillas de Géneros
        if (!empty($selectedGenres)) {
            $query->whereIn('genre', $selectedGenres);
        }

        $stories = $query->latest()->get();

        return view('community.index', compact('stories', 'searchTerm', 'selectedGenres', 'allGenres'));
    }
}