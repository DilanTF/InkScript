<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoryController extends Controller
{
    // Lista de géneros disponibles en la plataforma
    private $allGenres = ['Fantasía', 'Ciencia Ficción', 'Romance', 'Terror', 'Misterio', 'Aventura', 'Histórica'];

    /**
     * Muestra el listado de historias del usuario autenticado.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $stories = $user->stories; 
        
        return view('stories.index', compact('stories'));
    }

    /**
     * Muestra el formulario para crear una nueva historia.
     */
    public function create()
    {
        $genres = $this->allGenres;
        return view('stories.create', compact('genres'));
    }

    /**
     * Almacena una nueva historia en la base de datos.
     */
    public function store(Request $request)
    {
        // Validamos que envíe al menos 1 género
        $request->validate([
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string',
            'genres' => 'required|array|min:1', 
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Convertimos el array de géneros en un texto separado por comas
        $genreString = implode(', ', $request->genres);

        $user->stories()->create([
            'title' => $request->title,
            'description' => $request->description,
            'genre' => $genreString, // Guardamos el texto
        ]);

        return redirect()->route('stories.index')->with('success', '¡Historia creada correctamente en InkScript!');
    }

    /**
     * Muestra una historia específica y sus capítulos.
     */
    public function show(Story $story) 
    {
        $story->load(['chapters']);
        return view('stories.show', compact('story'));
    }

    /**
     * Muestra el formulario para editar una historia existente.
     */
    public function edit(Story $story)
    {
        $genres = $this->allGenres;
        
        // Convertimos el texto separado por comas de vuelta a un array para marcar las casillas
        $selectedGenres = explode(', ', $story->genre ?? '');
        
        return view('stories.edit', compact('story', 'genres', 'selectedGenres'));
    }

    /**
     * Actualiza la historia en la base de datos.
     */
    public function update(Request $request, Story $story)
    {
        $request->validate([
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string',
            'genres' => 'required|array|min:1',
            'status' => 'required|string', // Validamos el estado
        ]);
        
        $genreString = implode(', ', $request->genres);

        $story->update([
            'title' => $request->title,
            'description' => $request->description,
            'genre' => $genreString,
            'status' => $request->status, // Guardamos el estado
        ]);
        
        return redirect()->route('stories.index')->with('success', 'Historia actualizada con éxito.');
    }

    /**
     * Elimina la historia de la base de datos.
     */
    public function destroy(Story $story)
    {
        $story->delete();
        return redirect()->route('stories.index')->with('success', 'Historia eliminada correctamente.');
    }

    /**
     * Alterna el estado de seguimiento de una historia.
     */
    public function toggleFollow(Story $story)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // toggle() engancha o desengancha automáticamente la relación en la base de datos
        $user->followedStories()->toggle($story->id);
        
        $isFollowing = $user->followedStories()->where('story_id', $story->id)->exists();
        $mensaje = $isFollowing ? '¡Ahora sigues esta historia! Te avisaremos de los nuevos capítulos.' : 'Has dejado de seguir esta historia.';
        
        return back()->with('success', $mensaje);
    }
}